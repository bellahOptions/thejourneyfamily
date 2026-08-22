<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $trimmed = [];

        foreach (['couple_name', 'whatsapp', 'email', 'notes'] as $field) {
            if (is_string($this->input($field))) {
                $trimmed[$field] = trim($this->input($field));
            }
        }

        if ($trimmed !== []) {
            $this->merge($trimmed);
        }
    }

    public function rules(): array
    {
        return [
            'couple_name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{7,30}$/'],
            'email' => ['nullable', 'email', 'max:160'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'hp_field' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'whatsapp.regex' => 'Enter a valid WhatsApp number, e.g. 08012345678.',
        ];
    }

    /**
     * Honeypot check — same pattern as the retreat registration form.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (filled($this->input('hp_field'))) {
                logger()->info('Consultation booking honeypot triggered', [
                    'ip' => $this->ip(),
                    'ua' => $this->userAgent(),
                ]);

                $validator->errors()->add('couple_name', 'We couldn\'t process that. Please try again.');
            }
        });
    }
}
