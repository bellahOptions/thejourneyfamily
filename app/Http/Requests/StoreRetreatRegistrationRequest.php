<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            // 'email:rfc' rejects a lot of real-world addresses — plain 'email'
            // (RFCValidation + basic filter) is friendlier for a public form.
            'email' => ['required', 'email', 'max:160'],
            'wedding_anniversary' => ['required', 'date', 'before_or_equal:today'],
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

            // Honeypot — renamed from "website" to something less likely to be
            // autofilled by password managers / browser form-fill heuristics.
            'hp_field' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'participant_whatsapp.regex' => 'Enter a valid WhatsApp number, e.g. 08012345678.',
            'spouse_whatsapp.regex' => 'Enter a valid WhatsApp number, e.g. 08012345678.',
            'children_ages.required_if' => 'Share the children age(s) if you are coming with children.',
            'consent.accepted' => 'Please confirm that the details are accurate and that The Journey may contact you.',
            'wedding_anniversary.before_or_equal' => 'Wedding anniversary date can\'t be in the future.',
            'package_key.required' => 'Please select a package.',
        ];
    }

    /**
     * Honeypot check runs after normal validation so a bot fill doesn't
     * surface as a confusing, unattached top-level error — we reject it
     * quietly instead (fail closed, but without tipping off the bot).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (filled($this->input('hp_field'))) {
                // Log it (useful in dev to confirm the honeypot is working
                // rather than blocking a real user), then fail generically.
                report_bot_submission: // no-op label for readability
                logger()->info('Retreat registration honeypot triggered', [
                    'ip' => $this->ip(),
                    'ua' => $this->userAgent(),
                ]);

                $validator->errors()->add('couple_name', 'We couldn\'t process your registration. Please try again.');
            }
        });
    }
}