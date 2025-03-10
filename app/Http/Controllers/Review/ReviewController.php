<?php
namespace App\Http\Controllers\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;

class ReviewController extends Controller
{
    protected $reviewRepository;
    protected $apiTokenRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, ApiTokenRepositoryInterface $apiTokenRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->apiTokenRepository = $apiTokenRepository;
    }

    /**
     * Validate the API token.
     */
    private function validateToken(Request $request)
    {
        $token = $request->header('Authorization');

        if (!$token || !$this->apiTokenRepository->validateToken($token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return true;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

        $reviews = $this->reviewRepository->getAllReviews($request);
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

        $data = $request->validated();
        $review = $this->reviewRepository->createReview($data);
        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

        $review = $this->reviewRepository->getReview($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, string $id)
    {
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

        $data = $request->validated();

        $review = $this->reviewRepository->updateReview($id, $data);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

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
        $validationResponse = $this->validateToken($request);
        if ($validationResponse !== true) {
            return $validationResponse;
        }

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