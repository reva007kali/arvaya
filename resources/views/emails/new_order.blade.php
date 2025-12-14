<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #F9F7F2; color: #5E4926; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; border: 1px solid #E6D9B8; }
        .header { text-align: center; border-bottom: 1px solid #F2ECDC; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #5E4926; letter-spacing: 2px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #B89760; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .details { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .details td { padding: 10px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #9A7D4C; width: 150px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">ARVAYA DE AURE</div>
            <p>Notifikasi Pesanan Baru</p>
        </div>

        <p>Halo Admin,</p>
        <p>Ada pesanan baru yang masuk dan menunggu verifikasi pembayaran.</p>

        <table class="details">
            <tr>
                <td class="label">Nama User</td>
                <td>{{ $invitation->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Judul Undangan</td>
                <td>{{ $invitation->title }}</td>
            </tr>
            <tr>
                <td class="label">Paket</td>
                <td style="text-transform: uppercase; font-weight: bold;">{{ $invitation->package_type }}</td>
            </tr>
            <tr>
                <td class="label">Total Tagihan</td>
                <td style="font-family: monospace; font-size: 14px;">Rp {{ number_format($invitation->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>{{ $invitation->updated_at->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        <div style="text-align: center;">
            <p>Silakan login ke dashboard admin untuk melihat bukti transfer dan melakukan verifikasi.</p>
            {{-- Arahkan ke halaman transaksi admin --}}
            <a href="{{ route('admin.transactions') }}" class="btn">Cek Transaksi</a>
        </div>
    </div>
</body>
</html>