<?php

namespace App\Http\Requests;

use App\Http\Helpers\RequestTraitAuth;
use App\Http\Helpers\RequestTraitValidation;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    use RequestTraitAuth, RequestTraitValidation;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'is_completed' => 'required|boolean',
            'due_date' => 'required|date',
        ];
    }
}
