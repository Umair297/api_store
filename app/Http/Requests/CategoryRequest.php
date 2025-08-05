<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|unique:categories',
            'image' => 'nullable|string',
            'status' => 'required|in:0,1',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $id = $this->route('id');
            $rules['slug'] = 'nullable|string|unique:categories,slug,' . $id;
        }

        return $rules;
    }
}

