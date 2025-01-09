<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'reviewer' => 'required|string',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review_url' => 'sometimes|string',
            'reviewer_avatar_url' => 'sometimes|string',
            'review_date' => 'required|date',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title.',
            'title.string' => 'The title should be text.',
            'title.max' => 'The title should not exceed 255 characters.',
            'product_name.required' => 'Please provide a product name.',
            'product_name.string' => 'The product name should be text.',
            'product_name.max' => 'The product name should not exceed 255 characters.',
            'reviewer.required' => 'Please provide the reviewer\'s name.',
            'reviewer.string' => 'The reviewer\'s name should be text.',
            'content.required' => 'Please provide the content of the review.',
            'content.string' => 'The content should be text.',
            'rating.required' => 'Please provide a rating.',
            'rating.integer' => 'The rating should be a whole number.',
            'rating.min' => 'The rating should be at least 1.',
            'rating.max' => 'The rating should not be greater than 5.',
            'review_url.sometimes' => 'If provided, the review URL should be a valid URL.',
            'reviewer_avatar_url.sometimes' => 'If provided, the reviewer avatar URL should be a valid URL.',
            'review_date.required' => 'Please provide the review date.',
            'review_date.date' => 'The review date should be a valid date.',
        ];
    }
}