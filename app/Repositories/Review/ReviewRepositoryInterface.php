<?php
namespace App\Repositories\Review;
use Illuminate\Http\Request;

use App\Models\Review\Review;

/**
 * Interface ReviewRepositoryInterface
 *
 * Provides methods for managing reviews.
 */
interface ReviewRepositoryInterface
{
    /**
     * Retrieve all reviews.
     *
     * @return mixed
     */
    public function getAllReviews(Request $request);

    /**
     * Retrieve a specific review by its ID.
     *
     * @param int $id The ID of the review.
     * @return mixed
     */
    public function getReview($id): Review;

    /**
     * Create a new review.
     *
     * @param array $data The data for the new review.
     * @return mixed
     */
    public function createReview(array $data): Review;

    /**
     * Update an existing review.
     *
     * @param int $id The ID of the review to update.
     * @param array $data The new data for the review.
     * @return mixed
     */
    public function updateReview($id, array $data): Review;

    /**
     * Delete a review by its ID.
     *
     * @param int $id The ID of the review to delete.
     * @return mixed
     */
    public function deleteReview($id);

    /**
     * Import reviews from a file.
     *
     * @param mixed $file The file containing reviews to import.
     * @return mixed
     */
    public function importReviews($file);
}