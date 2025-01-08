<?php
namespace App\Repositories\Review;

use App\Models\Review\Review;
use App\Repositories\Repository;
use Carbon\Carbon;
use Exception;

class ReviewRepository extends Repository implements ReviewRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Review();
        parent::__construct($this->model);
    }

    public function getAllReviews()
    {
        return $this->model->paginate(50);
    }

    public function getReview($id): Review
    {
        return $this->find($id);
    }

    public function createReview(array $data)
    {
        $data['review_date'] = Carbon::parse($data['review_date'])->format('Y-m-d H:i:s');

        return $this->create($data);
    }

    public function updateReview($id, array $data)
    {
        $review = $this->update($id, $data);
        
        return $review->fresh();
    }

    public function deleteReview($id)
    {
        try {
            return $this->delete($id) ? true : false;
        } catch (Exception $e) {
            return false;
        }
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