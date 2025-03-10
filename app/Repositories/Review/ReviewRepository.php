<?php
namespace App\Repositories\Review;

use App\Models\Review\Review;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class ReviewRepository extends Repository implements ReviewRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Review();
        parent::__construct($this->model);
    }

    public function getAllReviews(Request $request)
    {
        $query = $this->model->query();
    
        $filters = [
            'title' => 'like',
            'status' => '=',
            'product_name' => 'like',
            'rating' => '=',
            'review_date' => '=',
            'review_url' => 'like',
            'reviewer' => 'like',
            'content' => 'like',
            'user_id' => '=',
            'post_id' => '=',
        ];
    
        foreach ($filters as $field => $operator) {
            if ($request->has($field)) {
                $value = $request->input($field);
                if ($operator === 'like') {
                    $query->where($field, $operator, '%' . $value . '%');
                } elseif ($field === 'review_date') {
                    $query->whereDate($field, $value);
                } else {
                    $query->where($field, $operator, $value);
                }
            }
        }

        if ($request->has('order_by')) {
            $orderBy = $request->input('order_by');
            $orderDirection = $request->input('order_direction', 'asc');
            $query->orderBy($orderBy, $orderDirection);
        }

        $limit = $request->input('limit', 10);
    
        return $query->paginate($limit);
    }

    public function getReview($id): Review
    {
        return $this->find($id);
    }

    public function createReview(array $data): Review
    {
        $data['review_date'] = Carbon::parse($data['review_date'])->format('Y-m-d H:i:s');

        return $this->create($data);
    }

    public function updateReview($id, array $data): Review
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
                    'title' => stripslashes($row['Title']),
                    'product_name' => $row['Reviewed Product/Establishment'],
                    'product_image_url' => $row['Product Image URL'],
                    'reviewer' => $row['Reviewer'],
                    'content' => stripslashes($row['Content']),
                    'review_url' => !empty($row['Review URL']) ? $row['Review URL'] : null,
                    'reviewer_avatar_url' => !empty($row['Reviewer Avatar URL']) ? $row['Reviewer Avatar URL'] : null,
                    'user_id' => !empty($row['User ID']) ? (int) $row['User ID'] : null,
                    'post_id' => !empty($row['Post ID']) ? (int) $row['Post ID'] : null,
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