<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('body'))) {
            $this->merge(['body' => trim($this->input('body'))]);
        }
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'min:3', 'max:500'],
            'hp_field' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Write your question before sending.',
        ];
    }

    /**
     * Honeypot check — same pattern as the retreat registration form.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (filled($this->input('hp_field'))) {
                logger()->info('Question honeypot triggered', [
                    'ip' => $this->ip(),
                    'ua' => $this->userAgent(),
                ]);

                $validator->errors()->add('body', 'We couldn\'t process that. Please try again.');
            }
        });
    }
}
