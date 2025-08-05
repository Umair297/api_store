<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // set to true to allow request
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:products',
            'slug' => 'nullable|string',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
        ];
         if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $id = $this->route('id');
            $rules['slug'] = 'nullable|string|unique:products,slug,' . $id;
        }
        return $rules;
    }
}

