<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
    .container { max-width: 560px; margin: 0 auto; background: #0a0f1e; border-radius: 8px; overflow: hidden; }
    .header { background: linear-gradient(135deg, #0d1428, #0a0f1e); padding: 32px; text-align: center; border-bottom: 2px solid #c9a84c; }
    .title { font-size: 26px; font-weight: bold; color: #c9a84c; letter-spacing: 3px; margin: 0; }
    .subtitle { font-size: 11px; color: #a0a0a0; margin-top: 6px; }
    .body { padding: 28px 32px; color: #f5f0e8; }
    .greeting { font-size: 16px; margin-bottom: 20px; }
    .info-box { background: #0d1428; border: 1px solid #c9a84c33; border-radius: 6px; padding: 16px; margin: 20px 0; }
    .info-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #ffffff11; font-size: 13px; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #a0a0a0; }
    .info-value { color: #f5f0e8; font-weight: bold; }
    .ticket-code { font-size: 22px; color: #c9a84c; letter-spacing: 4px; font-family: monospace; }
    .attachment-note { background: #c9a84c11; border: 1px solid #c9a84c33; border-radius: 6px; padding: 14px; margin: 20px 0; font-size: 13px; color: #c9a84c; }
    .event-box { background: #0d1428; border-left: 3px solid #c9a84c; padding: 14px 16px; margin: 20px 0; font-size: 13px; }
    .footer { text-align: center; padding: 20px 32px; font-size: 11px; color: #555; border-top: 1px solid #1a2040; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <p class="title">JUKUNG BULIK</p>
      <p class="subtitle">PERTUNJUKAN TEATER TRADISIONAL BANJAR</p>
    </div>
    <div class="body">
      <p class="greeting">Halo, <strong>{{ $order->nama }}</strong>! 🎭</p>
      <p style="color:#a0a0a0; font-size:13px;">
        Pembayaranmu telah dikonfirmasi. Berikut detail tiketmu:
      </p>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Kode Tiket</span>
          <span class="ticket-code">{{ $order->ticket_code }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Nama</span>
          <span class="info-value">{{ $order->nama }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Kategori</span>
          <span class="info-value">{{ strtoupper($order->ticketCategory->name) }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jumlah</span>
          <span class="info-value">{{ $order->quantity }} tiket</span>
        </div>
        <div class="info-row">
          <span class="info-label">Total Bayar</span>
          <span class="info-value">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
      </div>

      <div class="attachment-note">
        📎 <strong>E-ticket PDF terlampir</strong> di email ini.<br>
        Buka lampiran, simpan, dan tunjukkan QR code atau kode tiket saat masuk venue.
      </div>

      <div class="event-box">
        <p style="margin:0; color:#c9a84c; font-weight:bold; margin-bottom:8px;">📅 Info Acara</p>
        <p style="margin:4px 0; color:#f5f0e8;">Tanggal: <strong>01 Oktober 2026</strong></p>
        <p style="margin:4px 0; color:#f5f0e8;">Waktu: <strong>19.00 WITA</strong></p>
        <p style="margin:4px 0; color:#f5f0e8;">Venue: <strong>Gedung Balairung Banjarmasin</strong></p>
      </div>

      <p style="font-size:12px; color:#666; margin-top:24px;">
        Jika ada pertanyaan, hubungi panitia via WhatsApp atau Instagram @jukungbulik.
      </p>
    </div>
    <div class="footer">
      © 2026 JUKUNG BULIK. E-ticket ini berlaku untuk {{ $order->quantity }} orang.<br>
      Dilarang memperbanyak atau memindahtangankan tanpa izin panitia.
    </div>
  </div>
</body>
</html>
