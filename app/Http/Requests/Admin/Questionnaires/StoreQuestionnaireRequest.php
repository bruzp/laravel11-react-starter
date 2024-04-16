<?php

namespace App\Http\Requests\Admin\Questionnaires;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    public function prepareForInsert(): array
    {
        return $this->safe()
            ->merge(['admin_id' => $this->user(Admin::GUARD)->id])
            ->toArray();
    }
}
