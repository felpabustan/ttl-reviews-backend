<?php
namespace App\Repositories\Review;

use App\Models\Review\Review;
use Carbon\Carbon;
use Exception;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getAllReviews()
    {
        return Review::paginate(50);
    }

    public function getReviewById($id)
    {
        return Review::find($id);
    }

    public function createReview(array $data)
    {
        $data['review_date'] = Carbon::parse($data['review_date'])->format('Y-m-d H:i:s');

        return Review::create($data);
    }

    public function updateReview($id, array $data)
    {
        $review = Review::find($id);
        if ($review) {
            $review->update($data);
            return $review->fresh();
        }
        return null;
    }

    public function deleteReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
            return true;
        }
        return false;
    }

    public function importReviews($file)
    {
        try {
            $path = $file->getRealPath();
            $data = [];
            if (($handle = fopen($path, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $data[] = $row;
                }
                fclose($handle);
            }
            $header = array_shift($data);

            $mappedData = array_filter($data, function ($row) use ($header) {
                return count($row) === count($header);
            });

            $mappedData = array_map(function ($row) use ($header) {
                return array_combine($header, $row);
            }, $mappedData);

            foreach ($mappedData as $row) {
                if (!strtotime($row['Date Reviewed'])) {
                    continue;
                }

                $reviewData = [
                    'title' => $row['Title'],
                    'product_name' => $row['Reviewed Product/Establishment'],
                    'reviewer' => $row['Reviewer'],
                    'content' => $row['Content'],
                    'rating' => $row['Rating'],
                    'status' => $row['Status'],
                    'review_date' => Carbon::parse($row['Date Reviewed'])->format('Y-m-d H:i:s'),
                ];

                $this->createReview($reviewData);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}