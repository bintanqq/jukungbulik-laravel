<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    @page {
      margin: 0px;
    }
    html, body {
      margin: 0px;
      padding: 0px;
      background-color: #0a0f1e;
      width: 100%;
      height: 100%;
    }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #f5f0e8;
    }
    .container {
      border: 2px solid #c9a84c;
      border-radius: 8px;
      background-color: #0d1428;
      padding: 18px;
      
      /* Pemosisian absolut untuk akurasi border di DomPDF */
      position: absolute;
      top: 16px;
      left: 16px;
      right: 16px;
      bottom: 16px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #c9a84c;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }
    .title {
      font-size: 20px;
      font-weight: bold;
      color: #c9a84c;
      letter-spacing: 3px;
      margin: 0;
    }
    .subtitle {
      font-size: 8px;
      color: #a0a0a0;
      margin-top: 4px;
      letter-spacing: 1px;
    }
    .greeting {
      font-size: 12px;
      margin-bottom: 4px;
      font-weight: bold;
    }
    .intro {
      font-size: 9px;
      color: #a0a0a0;
      margin-bottom: 8px;
    }
    .info-box {
      background-color: #0a0f1e;
      border: 1px solid #c9a84c33;
      border-radius: 6px;
      padding: 8px;
      margin-bottom: 10px;
    }
    .info-row {
      display: table;
      width: 100%;
      padding: 3px 0;
      border-bottom: 1px solid #ffffff11;
    }
    .info-row:last-child {
      border-bottom: none;
    }
    .info-label {
      display: table-cell;
      width: 40%;
      font-size: 9px;
      color: #a0a0a0;
    }
    .info-value {
      display: table-cell;
      width: 60%;
      font-size: 9px;
      color: #f5f0e8;
      font-weight: bold;
      text-align: right;
    }
    .ticket-code {
      color: #c9a84c;
      font-family: monospace;
      font-size: 11px;
      letter-spacing: 1px;
    }
    .qr-section {
      text-align: center;
      margin-bottom: 10px;
      padding: 8px;
      background-color: #0a0f1e;
      border: 1px dashed #c9a84c44;
      border-radius: 6px;
    }
    .qr-section img {
      width: 135px; /* Memperbesar QR code */
      height: 135px;
    }
    .qr-label {
      font-size: 8px;
      color: #a0a0a0;
      margin-top: 4px;
    }
    .event-box {
      background-color: #0a0f1e;
      border-left: 3px solid #c9a84c;
      padding: 8px 12px;
      margin-bottom: 12px;
    }
    .event-title {
      color: #c9a84c;
      font-weight: bold;
      font-size: 10px;
      margin-bottom: 4px;
    }
    .event-detail {
      font-size: 9px;
      color: #f5f0e8;
      margin: 2px 0;
    }
    .footer {
      text-align: center;
      font-size: 7px;
      color: #555;
      border-top: 1px solid #1a2040;
      padding-top: 8px;
      margin-top: 10px; /* Jarak aman di akhir halaman */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="title">JUKUNG BULIK</div>
      <div class="subtitle">PERTUNJUKAN TEATER TRADISIONAL BANJAR</div>
    </div>
    
    <div class="greeting">Halo, {{ $order->nama }}!</div>
    <div class="intro">Pembayaran Anda telah dikonfirmasi. Berikut detail tiket resmi Anda:</div>
    
    <div class="info-box">
      <div class="info-row">
        <div class="info-label">Kode Tiket</div>
        <div class="info-value ticket-code">{{ $order->ticket_code }}</div>
      </div>
      <div class="info-row">
        <div class="info-label">Nama</div>
        <div class="info-value">{{ $order->nama }}</div>
      </div>
      <div class="info-row">
        <div class="info-label">Kategori</div>
        <div class="info-value">{{ strtoupper($order->ticketCategory->name) }}</div>
      </div>
      <div class="info-row">
        <div class="info-label">Jumlah</div>
        <div class="info-value">{{ $order->quantity }} tiket</div>
      </div>
      <div class="info-row">
        <div class="info-label">Total Bayar</div>
        <div class="info-value">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
      </div>
    </div>
    
    <div class="qr-section">
      <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
      <div class="qr-label">Tunjukkan QR code ini saat memasuki venue.</div>
    </div>
    
    <div class="event-box">
      <div class="event-title">📅 Info Acara</div>
      <div class="event-detail">Tanggal: <strong>01 Oktober 2026</strong></div>
      <div class="event-detail">Waktu: <strong>19.00 WITA</strong></div>
      <div class="event-detail">Venue: <strong>Gedung Balairung Banjarmasin</strong></div>
    </div>
    
    <div class="footer">
      © 2026 JUKUNG BULIK. E-ticket ini berlaku untuk {{ $order->quantity }} orang.<br>
      Dilarang memperbanyak atau memindahtangankan tanpa izin panitia.
    </div>
  </div>
</body>
</html>
