<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'book_shelf_id' => 'sometimes',
            'book_publisher_id' => 'sometimes',
            'book_author_id' => 'sometimes',
            'book_category_id' => 'sometimes',
            'book_name' => 'sometimes|max:255',
            'book_isbn' => 'sometimes|max:16',
            'book_stock' => 'sometimes|integer',
            'book_description' => 'sometimes|max:255',
            'book_img' => 'sometimes|image|mimes:jpeg,png,jpg|max:10240',
        ];
    }
}
