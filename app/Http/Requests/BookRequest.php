<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'book_shelf_id' => 'required',
            'book_publisher_id' => 'required',
            'book_author_id' => 'required',
            'book_category_id' => 'required',
            'book_name' => 'required|max:255',
            'book_isbn' => 'required|max:16',
            'book_stock' => 'required|integer',
            'book_description' => 'required|max:255',
            'book_img' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ];
    }
}
