<!DOCTYPE html>
<html lang="en">
    <body style="margin:0;background:#f7f4ee;color:#12211d;font-family:Arial,sans-serif;">
        <div style="max-width:720px;margin:0 auto;padding:32px 20px;">
            <div style="background:#ffffff;border:1px solid #d8cec0;border-radius:8px;padding:28px;">
                <p style="margin:0 0 8px;text-align:center;color:red;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">New registration</p>
                <h1 style="margin:0;text-align:center;color:#12211d;font-size:26px;line-height:1.2;">{{ $registration->couple_name }}</h1>

                <table role="presentation" style="width:100%;margin-top:24px;border-collapse:collapse;">
                    @foreach ([
                        'Email' => $registration->email,
                        'Wedding anniversary' => $registration->wedding_anniversary->format('F j, Y'),
                        'Participant WhatsApp' => $registration->participant_whatsapp,
                        'Spouse WhatsApp' => $registration->spouse_whatsapp,
                        'Transport' => $registration->transport_status,
                        'Coming with children' => $registration->bringing_children,
                        'Children ages' => $registration->children_ages ?: 'N/A',
                        'Package' => $registration->package_label,
                        'Amount' => $registration->formattedPackagePrice(),
                        'Payment made' => $registration->payment_made,
                    ] as $label => $value)
                        <tr>
                            <td style="width:42%;padding:10px 0;border-bottom:1px solid #d8cec0;color:#68766f;vertical-align:top;">{{ $label }}</td>
                            <td style="padding:10px 0;border-bottom:1px solid #d8cec0;font-weight:700;vertical-align:top;">{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>

                @foreach ([
                    'Expectations' => $registration->expectations,
                    'Prayer request' => $registration->prayer_request,
                    'Previous feedback' => $registration->previous_feedback,
                    'Other questions' => $registration->questions,
                ] as $label => $value)
                    @if ($value)
                        <div style="margin-top:20px;line-height:1.65;">
                            <strong>{{ $label }}</strong>
                            <p style="margin:8px 0 0;color:#52625c;">{{ $value }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </body>
</html>
