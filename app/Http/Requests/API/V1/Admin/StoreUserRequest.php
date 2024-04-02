<?php

namespace App\Http\Requests\API\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:16'],
            'is_admin' => ['numeric', 'min:0', 'max:1'], //* "0->user,1->admin"
            'is_ban' => ['numeric', 'min:0', 'max:1'], //* "0->is not ban,1->is ban"
            'email' => ['nullable', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'numeric', 'starts_with:01', 'digits:11', 'unique:users,phone_number'],
            'password' => ['nullable', Password::min(6)->mixedCase()->numbers()],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()], 422);
        throw new ValidationException($validator, $response);
    }
}
