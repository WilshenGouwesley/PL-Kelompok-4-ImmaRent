<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'gender' => ['required', 'in:male,female'],
            'class' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone_number' => 'phone number',
            'date_of_birth' => 'date of birth',
            'avatar' => 'profile photo',
        ];
    }
}
