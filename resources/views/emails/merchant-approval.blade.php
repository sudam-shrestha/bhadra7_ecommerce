<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <title>Your shop is approved</title>
    <style>
        body { margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table { border-collapse: collapse; }
        img { border: 0; outline: none; text-decoration: none; display: block; }
        a { text-decoration: none; }

        @media only screen and (max-width: 620px) {
            .container { width: 100% !important; }
            .px { padding-left: 20px !important; padding-right: 20px !important; }
            .stack { display: block !important; width: 100% !important; }
            .label-cell { padding-bottom: 2px !important; }
            .value-cell { padding-top: 0 !important; padding-bottom: 14px !important; }
            .btn a { display: block !important; }
        }
    </style>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:'Segoe UI', Helvetica, Arial, sans-serif; color:#363636;">

    {{-- Hidden preview text shown in the inbox list --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; font-size:1px; line-height:1px; color:#f3f4f6;">
        Good news! {{ $merchant->shop_name }} is approved. Your login details are inside.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3f4f6">
        <tr>
            <td align="center" style="padding:32px 12px;">

                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" border="0"
                    style="width:600px; max-width:600px;">

                    {{-- Logo --}}
                    <tr>
                        <td align="center" style="padding:0 0 20px 0;">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('frontend/images/logo.png') }}" alt="CodeIT Dokan" height="44"
                                    style="height:44px; width:auto;">
                            </a>
                        </td>
                    </tr>

                    {{-- Card --}}
                    <tr>
                        <td style="background-color:#ffffff; border-radius:20px; overflow:hidden; border:1px solid #e5e7eb;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                                {{-- Accent bar --}}
                                <tr>
                                    <td height="6" style="height:6px; line-height:6px; font-size:0; background-color:#04a53f;">&nbsp;</td>
                                </tr>

                                {{-- Heading --}}
                                <tr>
                                    <td class="px" style="padding:36px 40px 8px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" width="52" height="52"
                                                    style="width:52px; height:52px; background-color:#e6f6ec; border-radius:14px; font-size:24px; line-height:52px;">
                                                    &#127881;
                                                </td>
                                            </tr>
                                        </table>
                                        <h1 style="margin:20px 0 0 0; font-size:26px; line-height:34px; font-weight:800; color:#363636;">
                                            Your shop is approved
                                        </h1>
                                        <p style="margin:12px 0 0 0; font-size:16px; line-height:26px; color:#6b7280;">
                                            Hi {{ $merchant->name }}, welcome to CodeIT Dokan. <strong style="color:#363636;">{{ $merchant->shop_name }}</strong>
                                            is now approved and ready to sell.
                                        </p>
                                    </td>
                                </tr>

                                {{-- Credentials --}}
                                <tr>
                                    <td class="px" style="padding:24px 40px 0 40px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:700; color:#363636;">Your login details</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                            style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:14px;">
                                            <tr>
                                                <td style="padding:0 20px;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td class="stack label-cell" width="130" valign="top"
                                                                style="width:130px; padding:14px 0; font-size:13px; color:#6b7280; border-bottom:1px solid #e5e7eb;">
                                                                Email
                                                            </td>
                                                            <td class="stack value-cell" valign="top"
                                                                style="padding:14px 0; font-size:15px; font-weight:600; color:#363636; word-break:break-word; border-bottom:1px solid #e5e7eb;">
                                                                {{ $merchant->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="stack label-cell" width="130" valign="middle"
                                                                style="width:130px; padding:14px 0; font-size:13px; color:#6b7280;">
                                                                Password
                                                            </td>
                                                            <td class="stack value-cell" valign="middle" style="padding:14px 0;">
                                                                <span style="display:inline-block; padding:6px 14px; background-color:#fff1e8; border:1px dashed #f85f11; border-radius:8px; font-family:'Courier New', Courier, monospace; font-size:18px; font-weight:700; letter-spacing:2px; color:#f85f11;">
                                                                    {{ $password }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                {{-- Button --}}
                                <tr>
                                    <td class="px btn" style="padding:28px 40px 0 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" bgcolor="#f85f11" style="border-radius:999px; background-color:#f85f11;">
                                                    <a href="{{ $reviewUrl }}" target="_blank"
                                                        style="display:inline-block; padding:14px 32px; font-size:15px; font-weight:700; color:#ffffff; border-radius:999px; text-align:center;">
                                                        Log in to your dashboard
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                {{-- Next steps --}}
                                <tr>
                                    <td class="px" style="padding:32px 40px 0 40px;">
                                        <p style="margin:0 0 12px 0; font-size:14px; font-weight:700; color:#363636;">What to do next</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            @foreach ([
                                                'Log in with the details above.',
                                                'Add your products with prices and variants.',
                                                'Manage new orders as customers place them.',
                                            ] as $i => $step)
                                                <tr>
                                                    <td width="32" valign="top" style="width:32px; padding:0 0 12px 0;">
                                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                            <tr>
                                                                <td align="center" width="24" height="24"
                                                                    style="width:24px; height:24px; background-color:#e6f6ec; border-radius:12px; font-size:12px; font-weight:700; line-height:24px; color:#04a53f;">
                                                                    {{ $i + 1 }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="top" style="padding:2px 0 12px 0; font-size:15px; line-height:22px; color:#4b5563;">
                                                        {{ $step }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>

                                {{-- Security note --}}
                                <tr>
                                    <td class="px" style="padding:12px 40px 40px 40px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                            style="background-color:#fffbeb; border:1px solid #fde68a; border-radius:12px;">
                                            <tr>
                                                <td style="padding:14px 18px; font-size:13px; line-height:20px; color:#92400e;">
                                                    <strong>Keep your password safe.</strong> We recommend changing it after your first login, and never sharing it with anyone.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" class="px" style="padding:24px 20px 0 20px;">
                            <p style="margin:0; font-size:12px; line-height:20px; color:#9ca3af;">
                                You received this email because you applied to sell on {{ config('app.name') }}.
                            </p>
                            <p style="margin:6px 0 0 0; font-size:12px; line-height:20px; color:#9ca3af;">
                                &copy; {{ date('Y') }} CodeIT Dokan. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
