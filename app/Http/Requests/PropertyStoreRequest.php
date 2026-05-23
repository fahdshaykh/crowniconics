<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyStoreRequest extends FormRequest
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
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
            'country_id' => 'required|string|max:100',
            'state_id' => 'nullable|string|max:100',
            'city_id' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|string|max:50',
            'area_sqft' => 'required|numeric|min:0',
            'beds' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url|max:255',
            'features' => 'nullable|string',
        ];
    }
}
