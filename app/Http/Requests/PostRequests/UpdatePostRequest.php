<?php

namespace App\Http\Requests\PostRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'title'    => 'required|string',
            'content'  => 'required|string',
            'status'   => 'nullable|string|in:Active,Sold',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
            'voice'    => 'file|mimes:audio/mpeg,mpga,mp3,wav',
            'products' => 'array|exists:products,id',
        ];
    }
}
