<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return ['body' => ['required', 'string', 'max:500']];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'O comentário é obrigatório.',
            'body.string' => 'O comentário deve ser um texto.',
            'body.max' => 'O comentário não pode ter mais de 500 caracteres.',
        ];
    }
}
