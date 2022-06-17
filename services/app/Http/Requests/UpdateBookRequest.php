<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => "required|string|max:150",
            'isbn' => "required|string|min:10|max:14",
            'author_name' => "required|string|max:50",
            'description' => "required|string|max:500",
            'publish_date' => "required",
            'category_id' => "required",
        ];
    }
}
