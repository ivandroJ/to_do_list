<?php

namespace App\Http\Requests\TodoTask\V1;

use App\TodoTaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodoTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }
    public function attributes(): array
    {
        return [
            'title' => 'Título',
            'description' => 'Descrição',
        ];
    }
}
