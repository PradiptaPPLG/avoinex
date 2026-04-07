<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Status Refund Avoinex</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #279ED6; color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .footer { background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #777; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; }
        .status-approved { background-color: #E8F5E9; color: #2E7D32; }
        .status-rejected { background-color: #FFEBEE; color: #C62828; }
        .details { background-color: #f5f5f5; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; background-color: #279ED6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;">Avoinex</h1>
            <p style="margin:5px 0 0;">Update Status Permintaan Refund</p>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</strong>,</p>
            
            <p>Kami telah meninjau permintaan refund Anda untuk kode booking <strong>{{ $booking->booking_code }}</strong>.</p>

            @if($status === 'approved')
                <div class="status-badge status-approved">Refund Disetujui</div>
                <p>Kabar baik! Permintaan refund Anda telah <strong>disetujui</strong>. Dana akan dikembalikan sesuai dengan rincian di bawah ini:</p>
                
                <div class="details">
                    <div style="margin-bottom: 10px;"><strong>Rincian Refund:</strong></div>
                    <table width="100%">
                        <tr><td>Total Bayar:</td><td align="right">Rp {{ number_format($booking->total_price_usd * 15500, 0, ',', '.') }}</td></tr>
                        <tr><td>Nominal Refund:</td><td align="right"><strong>Rp {{ number_format($booking->refund_amount_usd * 15500, 0, ',', '.') }}</strong></td></tr>
                        @if($booking->refund_admin_notes)
                        <tr><td colspan="2" style="padding-top:10px; border-top:1px solid #ddd;"><strong>Catatan Admin:</strong><br>{{ $booking->refund_admin_notes }}</td></tr>
                        @endif
                    </table>
                </div>
                <p>Dana biasanya akan masuk ke rekening/metode pembayaran asal Anda dalam waktu 3-7 hari kerja.</p>
            @else
                <div class="status-badge status-rejected">Refund Ditolak</div>
                <p>Mohon maaf, permintaan refund Anda untuk saat ini <strong>belum bisa kami setujui</strong>.</p>
                
                <div class="details">
                    <strong>Alasan Penolakan:</strong><br>
                    {{ $booking->refund_admin_notes ?? 'Tidak ada catatan tambahan.' }}
                </div>
                <p>Status booking Anda tetap <strong>Confirmed</strong> dan tiket Anda masih berlaku untuk digunakan.</p>
            @endif

            <div class="details">
                <div style="margin-bottom: 10px;"><strong>Info Penerbangan:</strong></div>
                {{ $booking->flightInstance->schedule->originAirport->name }} ({{ $booking->flightInstance->schedule->originAirport->iata_code }}) 
                → {{ $booking->flightInstance->schedule->destinationAirport->name }} ({{ $booking->flightInstance->schedule->destinationAirport->iata_code }})<br>
                Tanggal: {{ $booking->flightInstance->flight_date->format('d M Y') }}
            </div>

            <center>
                <a href="{{ url('/') }}" class="btn">Buka Website Avoinex</a>
            </center>
        </div>
        <div class="footer">
            &copy; 2026 Avoinex Airlines. Selalu terbang lebih cerdas.<br>
            Jl. Raya Perjalanan No. 123, Jakarta, Indonesia.
        </div>
    </div>
</body>
</html>
