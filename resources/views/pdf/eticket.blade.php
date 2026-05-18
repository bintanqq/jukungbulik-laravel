<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    /* PENTING: Gunakan DejaVu Sans untuk PDF agar rendering stabil di DomPDF */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      background: #0a0f1e;
      color: #f5f0e8;
      width: 595px;
      height: 420px;
      padding: 24px;
    }
    .ticket-wrapper {
      border: 2px solid #c9a84c;
      border-radius: 8px;
      padding: 20px;
      height: 372px;
      background: #0d1428;
    }
    .header { border-bottom: 1px solid #c9a84c44; padding-bottom: 12px; margin-bottom: 16px; }
    .event-name { font-size: 22px; font-weight: bold; color: #c9a84c; letter-spacing: 3px; }
    .event-sub { font-size: 10px; color: #a0a0a0; margin-top: 2px; }
    .body { display: table; width: 100%; }
    .info { display: table-cell; width: 65%; vertical-align: top; padding-right: 20px; }
    .qr-section {
      display: table-cell;
      width: 35%;
      vertical-align: middle;
      text-align: center;
      border-left: 1px dashed #c9a84c44;
      padding-left: 20px;
    }
    .info-row { margin-bottom: 10px; }
    .info-label { font-size: 9px; color: #a0a0a0; text-transform: uppercase; letter-spacing: 1px; }
    .info-value { font-size: 13px; color: #f5f0e8; font-weight: bold; margin-top: 2px; }
    .ticket-code {
      font-size: 18px; color: #c9a84c; letter-spacing: 4px;
      background: #c9a84c11; border: 1px solid #c9a84c44;
      padding: 6px 10px; border-radius: 4px; display: inline-block; margin-top: 4px;
    }
    .qr-section img { width: 130px; height: 130px; }
    .qr-label { font-size: 8px; color: #a0a0a0; margin-top: 6px; }
    .category-badge {
      display: inline-block; background: #c9a84c22; border: 1px solid #c9a84c;
      color: #c9a84c; font-size: 10px; font-weight: bold;
      padding: 2px 8px; border-radius: 3px; letter-spacing: 1px;
    }
    .footer {
      border-top: 1px solid #c9a84c44; padding-top: 8px; margin-top: 12px;
      font-size: 8px; color: #555; text-align: center;
    }
  </style>
</head>
<body>
  <div class="ticket-wrapper">
    <div class="header">
      <div class="event-name">JUKUNG BULIK</div>
      <div class="event-sub">PERTUNJUKAN TEATER TRADISIONAL BANJAR</div>
    </div>
    <div class="body">
      <div class="info">
        <div class="info-row">
          <div class="info-label">Nama Pemegang</div>
          <div class="info-value">{{ $order->nama }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">Kategori</div>
          <div class="info-value">
            <span class="category-badge">{{ strtoupper($order->ticketCategory->name) }}</span>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Jumlah Tiket</div>
          <div class="info-value">{{ $order->quantity }} tiket</div>
        </div>
        <div class="info-row">
          <div class="info-label">Tanggal Acara</div>
          <div class="info-value">01 Oktober 2026 • 19.00 WITA</div>
        </div>
        <div class="info-row">
          <div class="info-label">Venue</div>
          <div class="info-value">Gedung Balairung Banjarmasin</div>
        </div>
        <div class="info-row">
          <div class="info-label">Kode Tiket</div>
          <div class="ticket-code">{{ $order->ticket_code }}</div>
        </div>
      </div>
      <div class="qr-section">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
        <div class="qr-label">Tunjukkan QR atau kode tiket<br>saat masuk venue</div>
      </div>
    </div>
    <div class="footer">
      E-ticket berlaku untuk {{ $order->quantity }} orang. Dilarang memperbanyak tanpa izin panitia.
    </div>
  </div>
</body>
</html>
