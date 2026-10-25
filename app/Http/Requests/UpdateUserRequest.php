<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // {user} pada route sudah berupa model hasil route model binding
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('user')->id)],
            'class' => ['nullable', 'string', 'max:50'],
        ];
    }
}
