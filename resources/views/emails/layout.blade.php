<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PersonalCareStore')</title>
</head>
<body style="margin:0;padding:0;background:#F6FAF7;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F6FAF7;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#FFFFFF;border:1px solid #E4EEE8;border-radius:16px;overflow:hidden;">
                <tr>
                    <td style="background:#17603C;padding:24px 28px;">
                        <div style="font-size:11px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#FFE6A8;">PersonalCareStore</div>
                        <h1 style="margin:8px 0 0;font-size:21px;line-height:1.25;color:#FFFFFF;font-weight:700;">@yield('heading')</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 28px;color:#374151;font-size:15px;line-height:1.65;">
                        @yield('content')
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 28px;border-top:1px solid #E4EEE8;color:#93A39A;font-size:12px;line-height:1.6;">
                        Need help? Reply to this email or contact us at
                        {{ settings()?->contact_email ?? 'support@personalcarestore.com' }}.
                    </td>
                </tr>
            </table>
            <div style="max-width:560px;padding:14px 8px 0;color:#93A39A;font-size:11px;text-align:center;">
                PersonalCareStore &middot; Khulna, Bangladesh
            </div>
        </td>
    </tr>
</table>
</body>
</html>
