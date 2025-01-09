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
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'product_name.required' => 'The product name is required.',
            'product_name.string' => 'The product name must be a string.',
            'product_name.max' => 'The product name may not be greater than 255 characters.',
            'reviewer.required' => 'The reviewer name is required.',
            'reviewer.string' => 'The reviewer name must be a string.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'rating.required' => 'The rating is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating may not be greater than 5.',
            'review_url.sometimes' => 'The review URL must be a string.',
            'reviewer_avatar_url.sometimes' => 'The reviewer avatar URL must be a string.',
            'review_date.required' => 'The review date is required.',
            'review_date.date' => 'The review date must be a valid date.',
        ];
    }
}