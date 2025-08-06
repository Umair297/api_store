<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('product');

        return [
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'slug' => 'nullable|string|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',

            'variants' => 'nullable|array',
            'variants.*.size' => 'required_with:variants|string',
            'variants.*.price' => 'required_with:variants|numeric',
            'variants.*.stock' => 'required_with:variants|integer',
        ];
    }
}
