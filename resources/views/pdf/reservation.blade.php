<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Facture</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #F4EFE6;
    display: flex;
    justify-content: center;
    padding: 24px 16px;
    color: #3a3028;
  }
  .facture {
    background: #fff;
    width: 520px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(91,76,58,0.1);
  }
  .header {
    background: #5B4C3A;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .hotel-name { color: #fff; font-size: 16px; font-weight: 600; }
  .hotel-name span { color: #8A7356; }
  .facture-label { color: #c9a97a; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; }
  .info-row {
    background: #f9f6f1;
    padding: 12px 24px;
    display: flex;
    gap: 28px;
    border-bottom: 1px solid #ede8e0;
    flex-wrap: wrap;
  }
  .info-label { font-size: 10px; text-transform: uppercase; color: #8A7356; font-weight: 600; }
  .info-value { font-size: 13px; font-weight: 500; margin-top: 2px; }
  .body { padding: 16px 24px; }
  .dates-row { display: flex; gap: 10px; margin-bottom: 14px; }
  .date-card {
    flex: 1;
    background: #f9f6f1;
    border: 1px solid #ede8e0;
    border-radius: 6px;
    padding: 10px 14px;
  }
  .table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  .table thead tr { background: #5B4C3A; color: #fff; }
  .table th { padding: 8px 12px; text-align: left; font-size: 11px; text-transform: uppercase; }
  .table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #ede8e0; }
  .total-row { display: flex; justify-content: flex-end; }
  .total-box {
    background: #5B4C3A;
    color: #fff;
    border-radius: 6px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .total-label { font-size: 11px; opacity: 0.7; text-transform: uppercase; }
  .total-amount { font-size: 18px; font-weight: 700; color: #c9a97a; }
  .footer { padding: 10px 24px; text-align: center; font-size: 11px; color: #a0917e; border-top: 1px solid #ede8e0; }
</style>
</head>
<body>
<div class="facture">

  <div class="header">
    <div class="hotel-name">Hotel <span>LaWiam</span></div>
    <div class="facture-label">Facture</div>
  </div>

  <div class="info-row">
    <div>
      <div class="info-label">Client</div>
      <div class="info-value">{{ $reservation->client->user->name ?? 'Inconnu' }}</div>
    </div>
    <div>
      <div class="info-label">Email</div>
      <div class="info-value">{{ $reservation->client->user->email ?? '—' }}</div>
    </div>
    <div>
      <div class="info-label">Chambre</div>
      <div class="info-value">N° {{ $reservation->chambre->numero ?? '—' }}</div>
    </div>
  </div>

  <div class="body">
    <div class="dates-row">
      <div class="date-card">
        <div class="info-label">Arrivée</div>
        <div class="info-value">{{ $reservation->date_debut }}</div>
      </div>
      <div class="date-card">
        <div class="info-label">Départ</div>
        <div class="info-value">{{ $reservation->date_fin }}</div>
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Description</th><th>Nuits</th><th>Prix/nuit</th><th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Chambre N° {{ $reservation->chambre->numero ?? '—' }}</td>
          <td>{{ $nbNuits }}</td>
          <td>{{ $reservation->chambre->prix }} DH</td>
          <td>{{ $total }} DH</td>
        </tr>
      </tbody>
    </table>

    <div class="total-row">
      <div class="total-box">
        <span class="total-label">Total</span>
        <span class="total-amount">{{ $total }} DH</span>
      </div>
    </div>
  </div>

  <div class="footer">Merci pour votre confiance — Hotel LaWiam</div>

</div>
</body>
</html>