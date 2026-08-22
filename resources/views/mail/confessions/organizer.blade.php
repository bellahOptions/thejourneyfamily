<!DOCTYPE html>
<html lang="en">
    <body style="margin:0;background:#f7f4ee;color:#12211d;font-family:Arial,sans-serif;">
        <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
            <div style="background:#ffffff;border:1px solid #d8cec0;border-radius:8px;padding:28px;">
                <p style="margin:0 0 8px;text-align:center;color:red;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">New anonymous confession</p>
                <h1 style="margin:0;text-align:center;color:#12211d;font-size:24px;line-height:1.3;">{{ config('retreat.name') }}</h1>

                <div style="margin-top:24px;background:#f7f4ee;border:1px solid #d8cec0;border-radius:8px;padding:20px;line-height:1.7;color:#23352f;">
                    {{ $confession->body }}
                </div>

                <p style="margin-top:20px;color:#68766f;font-size:13px;">
                    Submitted {{ $confession->created_at->timezone(config('retreat.timezone'))->format('F j, Y g:i A') }} WAT. No identifying information was collected.
                </p>
            </div>
        </div>
    </body>
</html>
