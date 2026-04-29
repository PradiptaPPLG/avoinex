<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Refund Diterima — Avoinex</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:'Segoe UI',Arial,Helvetica,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:32px 0;">
<tr><td align="center">

<!-- Main Card -->
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

    <!-- Header -->
    <tr>
        <td style="background:linear-gradient(135deg,#f0a500,#e08c00); padding:32px 40px; text-align:center;">
            <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:800; letter-spacing:1px;">AVOINEX</h1>
            <p style="margin:8px 0 0; color:rgba(255,255,255,0.9); font-size:14px;">Permintaan Refund Diterima</p>
        </td>
    </tr>

    <!-- Status Banner -->
    <tr>
        <td style="padding:28px 40px 0; text-align:center;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background:#fff8e1; border:2px dashed #f0a500; border-radius:12px; padding:20px; text-align:center;">
                        <p style="margin:0 0 4px; font-size:13px; color:#856404; text-transform:uppercase; letter-spacing:1.5px; font-weight:600;">⏳ Status Permintaan</p>
                        <p style="margin:0; font-size:22px; font-weight:800; color:#e08c00; letter-spacing:1px;">SEDANG DIPROSES</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Greeting -->
    <tr>
        <td style="padding:24px 40px 0;">
            <p style="margin:0; font-size:15px; color:#333;">
                Halo, <strong>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</strong>,
            </p>
            <p style="margin:12px 0 0; font-size:14px; color:#555; line-height:1.6;">
                Kami telah <strong>menerima permintaan refund</strong> Anda untuk booking berikut.
                Tim kami akan meninjau dan memproses permintaan ini dalam <strong>1–3 hari kerja</strong>.
                Hasil keputusan akan dikirimkan ke email ini.
            </p>
        </td>
    </tr>

    <!-- Booking Code Banner -->
    <tr>
        <td style="padding:20px 40px 0; text-align:center;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background:#eef7fc; border:2px dashed #279ED6; border-radius:12px; padding:16px; text-align:center;">
                        <p style="margin:0 0 4px; font-size:12px; color:#666; text-transform:uppercase; letter-spacing:1.5px;">Booking Code</p>
                        <p style="margin:0; font-size:28px; font-weight:800; color:#279ED6; letter-spacing:3px;">{{ $booking->booking_code }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Flight Info -->
    <tr>
        <td style="padding:20px 40px 0;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align:left; width:40%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;">From</p>
                        <p style="margin:4px 0 0; font-size:22px; font-weight:800; color:#222;">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</p>
                        <p style="margin:2px 0 0; font-size:13px; color:#666;">{{ $booking->flightInstance->schedule->originAirport->city }}</p>
                    </td>
                    <td style="text-align:center; width:20%; vertical-align:middle;">
                        <p style="margin:0; font-size:22px; color:#279ED6;">✈</p>
                        <p style="margin:0; font-size:11px; color:#999;">Direct</p>
                    </td>
                    <td style="text-align:right; width:40%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;">To</p>
                        <p style="margin:4px 0 0; font-size:22px; font-weight:800; color:#222;">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</p>
                        <p style="margin:2px 0 0; font-size:13px; color:#666;">{{ $booking->flightInstance->schedule->destinationAirport->city }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Refund Details -->
    <tr>
        <td style="padding:20px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fa; border-radius:10px; padding:16px;">
                <tr>
                    <td style="padding:10px 16px; width:50%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Tanggal Penerbangan</p>
                        <p style="margin:4px 0 0; font-size:14px; font-weight:700; color:#222;">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                    </td>
                    <td style="padding:10px 16px; width:50%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Tanggal Pengajuan</p>
                        <p style="margin:4px 0 0; font-size:14px; font-weight:700; color:#222;">{{ now()->format('d M Y, H:i') }} WIB</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 16px;" colspan="2">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Total Dibayar</p>
                        <p style="margin:4px 0 0; font-size:18px; font-weight:800; color:#279ED6;">
                            Rp {{ number_format($booking->total_price_usd * config('app.usd_to_idr', 15500), 0, ',', '.') }}
                        </p>
                    </td>
                </tr>
                @if($booking->refund_reason)
                <tr>
                    <td style="padding:10px 16px; border-top:1px solid #eee;" colspan="2">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Alasan Refund</p>
                        <p style="margin:4px 0 0; font-size:14px; color:#555;">{{ $booking->refund_reason }}</p>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>

    <!-- Refund Policy -->
    <tr>
        <td style="padding:0 40px 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f0f7ff; border-left:4px solid #279ED6; border-radius:0 8px 8px 0; padding:14px 16px;">
                <tr>
                    <td>
                        <p style="margin:0 0 6px; font-size:13px; font-weight:700; color:#1a7ab5;">ℹ️ Kebijakan Refund Avoinex</p>
                        <p style="margin:0; font-size:12px; color:#555; line-height:1.6;">
                            • Dibatalkan <strong>&gt; 24 jam</strong> sebelum penerbangan: <strong>Refund 75%</strong><br>
                            • Dibatalkan <strong>&lt; 24 jam</strong> sebelum penerbangan: <strong>Refund 50%</strong><br>
                            • Dana akan masuk dalam <strong>3–7 hari kerja</strong> setelah disetujui
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Divider -->
    <tr>
        <td style="padding:0 40px;">
            <hr style="border:none; border-top:1px dashed #ddd; margin:0;">
        </td>
    </tr>

    <!-- How to Check Status -->
    <tr>
        <td style="padding:20px 40px;">
            <p style="margin:0 0 8px; font-size:13px; font-weight:700; color:#222; text-transform:uppercase; letter-spacing:1px;">Cara Cek Status Refund</p>
            <p style="margin:0; font-size:13px; color:#555; line-height:1.6;">
                Anda dapat memantau status permintaan refund kapan saja di halaman <strong>Cek Pesanan</strong>:
            </p>
            <table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:12px;">
                <tr>
                    <td style="background:#279ED6; border-radius:10px; padding:12px 24px; text-align:center;">
                        <a href="{{ url('/booking/find') }}" style="color:#fff; font-size:14px; font-weight:700; text-decoration:none;">
                            🔍 Cek Status Pesanan
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8f9fa; padding:24px 40px; text-align:center; border-top:1px solid #eee;">
            <p style="margin:0 0 4px; font-size:12px; color:#999;">Terima kasih telah memercayakan perjalanan Anda kepada Avoinex.</p>
            <p style="margin:0; font-size:12px; color:#bbb;">Email ini dikirim otomatis. Harap tidak membalas email ini.</p>
        </td>
    </tr>

</table>
<!-- /Main Card -->

</td></tr>
</table>

</body>
</html>
