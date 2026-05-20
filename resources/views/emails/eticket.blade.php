<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; padding: 20px; max-width: 600px; margin: 0 auto;">
  <p>Halo <strong>{{ $order->nama }}</strong>,</p>

  <p>Pembayaran Anda untuk tiket <strong>JUKUNG BULIK</strong> telah berhasil dikonfirmasi.</p>

  <p>E-ticket resmi Anda telah dilampirkan pada email ini dalam format PDF. Silakan unduh, simpan, dan tunjukkan QR Code pada tiket tersebut saat memasuki venue pertunjukan.</p>

  <p><strong>Ringkasan Detail Tiket:</strong><br>
  - Kode Tiket: {{ $order->ticket_code }}<br>
  - Kategori: {{ strtoupper($order->ticketCategory->name) }}<br>
  - Jumlah: {{ $order->quantity }} tiket</p>

  <p>Terima kasih,<br><strong>Panitia Jukung Bulik</strong></p>
</body>
</html>
