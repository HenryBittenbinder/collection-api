<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['sometimes', 'required', 'string', 'max:255'],
            'brand' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'condition' => ['sometimes', 'required', Rule::in(['novo', 'excelente', 'bom', 'regular'])],
            'estimated_value' => ['sometimes', 'nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'asking_price' => ['sometimes', 'nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'availability' => ['sometimes', 'required', Rule::in(['exibicao', 'venda', 'troca'])],
            'photo' => ['sometimes', 'nullable', 'image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser um texto.',
            'max.string' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'condition.in' => 'A condição deve ser novo, excelente, bom ou regular.',
            'availability.in' => 'A disponibilidade deve ser exibição, venda ou troca.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'min.numeric' => 'O campo :attribute não pode ser menor que zero.',
            'decimal' => 'O campo :attribute deve ter no máximo duas casas decimais.',
            'image' => 'O arquivo enviado deve ser uma imagem.',
            'max.file' => 'A foto não pode ter mais de 4 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome', 'category' => 'categoria', 'brand' => 'marca',
            'description' => 'descrição', 'condition' => 'condição',
            'estimated_value' => 'valor estimado', 'asking_price' => 'preço pedido',
            'availability' => 'disponibilidade', 'photo' => 'foto',
        ];
    }
}
