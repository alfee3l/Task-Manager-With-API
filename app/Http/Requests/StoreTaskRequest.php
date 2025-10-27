<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'priority' => 'required|in:high,medium,low',

        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'العنوان يجب أن يكون مدخل.',
            'title.max' => ' العنوان يجب أن يكون اقل من 50 حرف .',
            'priority.required' => ' الاولية يجب أن تكون مدخل.',
            'priority.integer' => ' الاولية يجب أن تكون رقم.',
            'priority.min' => ' الاولية يجب أن تكون اكبر من 1.',
            'priority.max' => ' الاولية يجب أن تكون اقل من 5.',
        ];
    }
}
