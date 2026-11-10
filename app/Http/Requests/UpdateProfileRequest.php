<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'username' => ['sometimes', 'required', 'string', 'max:255', 'regex:/^\S+$/u', Rule::unique('users', 'username')->ignore($userId)],
            'bio' => ['sometimes', 'nullable', 'string', 'max:160'],
            'avatar' => ['sometimes', 'nullable', 'image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'username.required' => 'O nome de usuário é obrigatório.',
            'username.string' => 'O nome de usuário deve ser um texto.',
            'username.max' => 'O nome de usuário não pode ter mais de 255 caracteres.',
            'username.regex' => 'O nome de usuário não pode conter espaços.',
            'username.unique' => 'Este nome de usuário já está em uso.',
            'bio.string' => 'A biografia deve ser um texto.',
            'bio.max' => 'A biografia não pode ter mais de 160 caracteres.',
            'avatar.image' => 'O avatar enviado deve ser uma imagem.',
            'avatar.max' => 'O avatar não pode ter mais de 4 MB.',
        ];
    }
}
