<?php

namespace App\Http\Controllers\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Review\ReviewRepositoryInterface;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = $this->reviewRepository->getAllReviews();
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'reviewer' => 'required|string',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review_url' => 'sometimes|string',
            'reviewer_avatar_url' => 'sometimes|string',
            'review_date' => 'required|date',
        ]);

        $review = $this->reviewRepository->createReview($data);
        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = $this->reviewRepository->getReview($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'product_name' => 'sometimes|string|max:255',
            'reviewer' => 'sometimes|string',
            'content' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
            'review_url' => 'sometimes|string',
            'reviewer_avatar_url' => 'sometimes|string',
            'review_date' => 'sometimes|date',
            'status' => 'sometimes|string',
        ]);

        $review = $this->reviewRepository->updateReview($id, $data);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->reviewRepository->deleteReview($id);
        if (!$deleted) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json(['message' => 'Review deleted successfully']);
    }

    /**
     * Import reviews from a CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $import = $this->reviewRepository->importReviews($file);

        if(!$import) {
            return response()->json(['message' => 'Failed to import reviews'], 500);
        }

        return response()->json(['message' => 'Reviews imported successfully']);
    }
}
