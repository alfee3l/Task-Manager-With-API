<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
           'title' => 'sometimes|string|max:50',
            'description' => 'sometimes|nullable|string',
            'priority' => 'sometimes|integer|min:1|max:5',
        ];
    }
   public function messages()
   {
     return [
       'title.max' => ' العنوان يجب أن يكون اقل من 50 حرف .',
       'priority.integer' => ' الاولية يجب أن تكون رقم.',
       'priority.min' => ' الاولية يجب أن تكون اكبر من 1.',
       'priority.max' => ' الاولية يجب أن تكون اقل من 5.',
     ];
   }
}
