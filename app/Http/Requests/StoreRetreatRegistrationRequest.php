<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRetreatRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $trimmed = [];

        foreach ([
            'couple_name',
            'email',
            'participant_whatsapp',
            'spouse_whatsapp',
            'children_ages',
            'expectations',
            'prayer_request',
            'previous_feedback',
            'questions',
        ] as $field) {
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
            'email' => ['required', 'email:rfc', 'max:160'],
            'wedding_anniversary' => ['required', 'date'],
            'participant_whatsapp' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{7,30}$/'],
            'spouse_whatsapp' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{7,30}$/'],
            'transport_status' => ['required', Rule::in(['Yes', 'No', 'Other'])],
            'bringing_children' => ['required', Rule::in(['Yes', 'No', 'Maybe'])],
            'children_ages' => ['required_if:bringing_children,Yes', 'nullable', 'string', 'max:120'],
            'expectations' => ['nullable', 'string', 'max:2000'],
            'prayer_request' => ['nullable', 'string', 'max:2000'],
            'previous_feedback' => ['nullable', 'string', 'max:2000'],
            'payment_made' => ['required', Rule::in(['Yes', 'No'])],
            'package_key' => ['required', Rule::in(array_keys(config('retreat.packages', [])))],
            'questions' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'participant_whatsapp.regex' => 'Enter a valid WhatsApp number.',
            'spouse_whatsapp.regex' => 'Enter a valid WhatsApp number.',
            'children_ages.required_if' => 'Share the children age(s) if you are coming with children.',
            'consent.accepted' => 'Please confirm that the details are accurate and that The Journey may contact you.',
            'website.prohibited' => 'Your registration could not be submitted.',
        ];
    }
}
