<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => ['required', 'integer', 'exists:items,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'item_id.required' => 'Selecione um item para iniciar a conversa.',
            'item_id.integer' => 'O item selecionado é inválido.',
            'item_id.exists' => 'O item selecionado não existe.',
        ];
    }
}
