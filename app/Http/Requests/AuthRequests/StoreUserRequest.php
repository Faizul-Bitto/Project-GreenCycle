<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
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
            'phone'    => 'required|min:11|regex:/^([0-9\s\-\+\(\)]*)$/',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|array|min:1|max:1|exists:roles,name',
        ];
    }
}
