<?php

namespace App\Http\Requests\TodoTask\V1;

use App\TodoTaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoTaskRequest extends FormRequest
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
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->label(), TodoTaskStatusEnum::cases())),
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'Status',
        ];
    }
}
