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
}
