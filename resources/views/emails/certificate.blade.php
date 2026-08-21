<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; padding: 20px; max-width: 600px; margin: 0 auto;">
  <p>Halo <strong>{{ $order->certificate_name }}</strong>,</p>

  <p>Sertifikat kehadiran Anda untuk pertunjukan <strong>JUKUNG BULIK 2026</strong> telah berhasil dibuat.</p>

  <p>Sertifikat digital Anda telah dilampirkan pada email ini dalam format gambar (PNG). Silakan unduh dan simpan sebagai kenang-kenangan.</p>

  <p><strong>Detail Sertifikat:</strong><br>
  - Nama: {{ $order->certificate_name }}<br>
  - Kode Sertifikat: {{ $order->certificate_code }}<br>
  - Kode Tiket: {{ $order->ticket_code }}</p>

  <p>Anda juga dapat mengunduh sertifikat kapan saja melalui tautan berikut:<br>
  <a href="{{ route('certificate.download', ['ticketCode' => $order->ticket_code]) }}">Unduh Sertifikat</a></p>

  <p>Terima kasih atas partisipasi Anda.<br><strong>Panitia Jukung Bulik</strong></p>
</body>
</html>
