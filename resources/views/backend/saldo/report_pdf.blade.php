<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Saldo</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .saldo-header {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Saldo</h1>
        @if ($startDate && $endDate)
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        @endif
        <p>Total Keseluruhan Saldo: {{ 'Rp ' . number_format($totalSaldo, 2, ',', '.') }}</p>
    </div>

    @foreach ($saldos as $saldo)
        <h3>{{ $saldo->nama }} (Saldo Akhir: {{ 'Rp ' . number_format($saldo->balance, 2, ',', '.') }})</h3>
        @if ($saldo->transactions->isEmpty())
            <p>Tidak ada transaksi untuk periode ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Kredit</th>
                        <th class="text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saldo->transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $transaction->keterangan }}</td>
                            <td class="text-right">{{ 'Rp ' . number_format($transaction->debit, 2, ',', '.') }}</td>
                            <td class="text-right">{{ 'Rp ' . number_format($transaction->kredit, 2, ',', '.') }}</td>
                            <td class="text-right">{{ 'Rp ' . number_format($transaction->saldo_akhir, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>

</html>