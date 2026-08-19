<?php

$organizerEmails = env(
    'RETREAT_ORGANIZER_EMAILS',
    env('RETREAT_ORGANIZER_EMAIL', 'bellahoptions@gmail.com')
);

return [
    'name' => 'The Journey Couples Retreat S6',
    'event_date' => env('RETREAT_EVENT_DATE', '2026-08-31 09:00:00'),
    'timezone' => env('RETREAT_TIMEZONE', 'Africa/Lagos'),
    'organizer_emails' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) $organizerEmails)
    ))),

    'packages' => [
        'fan-room' => [
            'label' => 'Package 1',
            'room' => 'Fan Room',
            'nights' => 2,
            'meals' => 4,
            'price' => 50000,
            'description' => '2 nights accommodation in a fan room with 4 meals per couple.',
        ],
        'standard-ac-room' => [
            'label' => 'Package 2',
            'room' => 'Standard AC Room',
            'nights' => 2,
            'meals' => 4,
            'price' => 70000,
            'description' => '2 nights accommodation in a standard AC room with 4 meals per couple.',
        ],
        'big-ac-room' => [
            'label' => 'Package 3',
            'room' => 'Big AC Room',
            'nights' => 2,
            'meals' => 4,
            'price' => 100000,
            'description' => '2 nights accommodation in a big AC room with 4 meals per couple.',
        ],
    ],

    'payment' => [
        'bank_name' => 'Fidelity Bank',
        'account_name' => 'THE JOURNEY12456',
        'account_number' => '5700143676',
        'proof_whatsapp' => '08054461053',
    ],
];
