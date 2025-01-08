<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'product_name' => 'sometimes|string|max:255',
            'reviewer' => 'sometimes|string',
            'content' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
            'review_url' => 'sometimes|string',
            'reviewer_avatar_url' => 'sometimes|string',
            'review_date' => 'sometimes|date',
            'status' => 'sometimes|string'
        ];
    }
}
