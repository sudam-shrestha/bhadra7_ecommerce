<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <title>New merchant registration</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse;
        }

        img {
            border: 0;
            outline: none;
            text-decoration: none;
            display: block;
        }

        a {
            text-decoration: none;
        }

        @media only screen and (max-width: 620px) {
            .container {
                width: 100% !important;
            }

            .px {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .stack {
                display: block !important;
                width: 100% !important;
            }

            .label-cell {
                padding-bottom: 2px !important;
            }

            .value-cell {
                padding-top: 0 !important;
                padding-bottom: 14px !important;
            }

            .btn a {
                display: block !important;
            }
        }
    </style>
</head>

<body
    style="margin:0; padding:0; background-color:#f3f4f6; font-family:'Segoe UI', Helvetica, Arial, sans-serif; color:#363636;">

    {{-- Hidden preview text shown in the inbox list --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; font-size:1px; line-height:1px; color:#f3f4f6;">
        {{ $merchant->shop_name }} has asked to join CodeIT Dokan and is waiting for your approval.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3f4f6">
        <tr>
            <td align="center" style="padding:32px 12px;">

                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0"
                    border="0" style="width:600px; max-width:600px;">

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
                        <td
                            style="background-color:#ffffff; border-radius:20px; overflow:hidden; border:1px solid #e5e7eb;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                                {{-- Accent bar --}}
                                <tr>
                                    <td height="6"
                                        style="height:6px; line-height:6px; font-size:0; background-color:#f85f11;">
                                        &nbsp;</td>
                                </tr>

                                {{-- Heading --}}
                                <tr>
                                    <td class="px" style="padding:36px 40px 8px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" width="52" height="52"
                                                    style="width:52px; height:52px; background-color:#fff1e8; border-radius:14px; font-size:24px; line-height:52px;">
                                                    &#127978;
                                                </td>
                                            </tr>
                                        </table>
                                        <h1
                                            style="margin:20px 0 0 0; font-size:26px; line-height:34px; font-weight:800; color:#363636;">
                                            New merchant registration
                                        </h1>
                                        <p style="margin:12px 0 0 0; font-size:16px; line-height:26px; color:#6b7280;">
                                            A new shop has asked to join CodeIT Dokan and is waiting for your approval.
                                        </p>
                                    </td>
                                </tr>

                                {{-- Status badge --}}
                                <tr>
                                    <td class="px" style="padding:20px 40px 0 40px;">
                                        <span
                                            style="display:inline-block; padding:6px 14px; border-radius:999px; background-color:#fff1e8; color:#f85f11; font-size:13px; font-weight:700;">
                                            Status: {{ ucfirst($merchant->status) }}
                                        </span>
                                    </td>
                                </tr>

                                {{-- Details --}}
                                <tr>
                                    <td class="px" style="padding:24px 40px 0 40px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                            border="0"
                                            style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:14px;">
                                            @php
                                                $rows = [
                                                    ['Shop name', $merchant->shop_name],
                                                    ['Owner', $merchant->name],
                                                    ['Email', $merchant->email],
                                                    ['Phone', $merchant->contact],
                                                    ['Requested on', $merchant->created_at->format('d M Y, h:i A')],
                                                ];
                                            @endphp
                                            @foreach ($rows as $i => [$label, $value])
                                                <tr>
                                                    <td style="padding:0 20px;">
                                                        <table role="presentation" width="100%" cellpadding="0"
                                                            cellspacing="0" border="0">
                                                            <tr>
                                                                <td class="stack label-cell" width="130"
                                                                    valign="top"
                                                                    style="width:130px; padding:14px 0; font-size:13px; color:#6b7280;
                                                                    {{ $i < count($rows) - 1 ? 'border-bottom:1px solid #e5e7eb;' : '' }}">
                                                                    {{ $label }}
                                                                </td>
                                                                <td class="stack value-cell" valign="top"
                                                                    style="padding:14px 0; font-size:15px; font-weight:600; color:#363636; word-break:break-word;
                                                                    {{ $i < count($rows) - 1 ? 'border-bottom:1px solid #e5e7eb;' : '' }}">
                                                                    {{ $value }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>

                                {{-- Message --}}
                                <tr>
                                    <td class="px" style="padding:24px 40px 0 40px;">
                                        <p style="margin:0; font-size:15px; line-height:24px; color:#4b5563;">
                                            Check the details and approve the request from the admin panel. After
                                            approval,
                                            the merchant will receive their login details by email.
                                        </p>
                                    </td>
                                </tr>

                                {{-- Button --}}
                                <tr>
                                    <td class="px btn" style="padding:28px 40px 40px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" bgcolor="#04a53f"
                                                    style="border-radius:999px; background-color:#04a53f;">
                                                    <a href="{{ $reviewUrl }}" target="_blank"
                                                        style="display:inline-block; padding:14px 32px; font-size:15px; font-weight:700; color:#ffffff; border-radius:999px; text-align:center;">
                                                        Review in admin panel
                                                    </a>
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
                                You received this email because you are an administrator of {{ config('app.name') }}.
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

