<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'A mensagem é obrigatória.',
            'body.string' => 'A mensagem deve ser um texto.',
            'body.max' => 'A mensagem não pode ter mais de 1000 caracteres.',
        ];
    }
}
