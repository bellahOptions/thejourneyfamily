<!DOCTYPE html>
<html lang="en">
    <body style="margin:0;background:#f7f4ee;color:#12211d;font-family:Arial,sans-serif;">
        <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
            <div style="background:#ffffff;border:1px solid #d8cec0;border-radius:8px;padding:28px;">
                <p style="margin:0 0 8px;color:#a33852;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">Registration received</p>
                <h1 style="margin:0;color:#12211d;font-size:28px;line-height:1.2;">Thank you, {{ $registration->couple_name }}.</h1>

                <p style="margin:20px 0 0;line-height:1.7;color:#52625c;">
                    We received your registration for {{ config('retreat.name') }}. The organizers have also received a copy.
                </p>

                <table role="presentation" style="width:100%;margin-top:24px;border-collapse:collapse;">
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;color:#68766f;">Package</td>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;text-align:right;font-weight:700;">{{ $registration->package_label }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;color:#68766f;">Amount</td>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;text-align:right;font-weight:700;">{{ $registration->formattedPackagePrice() }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;color:#68766f;">Event date</td>
                        <td style="padding:10px 0;border-bottom:1px solid #d8cec0;text-align:right;font-weight:700;">{{ $eventDate->timezone(config('retreat.timezone'))->format('F j, Y g:i A') }} WAT</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;color:#68766f;">Payment made</td>
                        <td style="padding:10px 0;text-align:right;font-weight:700;">{{ $registration->payment_made }}</td>
                    </tr>
                </table>

                <div style="margin-top:24px;background:#edf5f3;border:1px solid rgba(47,111,115,.2);border-radius:8px;padding:16px;line-height:1.6;color:#23352f;">
                    <strong>Payment details</strong><br>
                    {{ $payment['bank_name'] }}<br>
                    {{ $payment['account_name'] }}<br>
                    {{ $payment['account_number'] }}<br>
                    Send proof of payment to {{ $payment['proof_whatsapp'] }} on WhatsApp.
                </div>
            </div>
        </div>
    </body>
</html>
