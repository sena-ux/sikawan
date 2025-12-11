<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jurnal Harian</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f6f7fb;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .report-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(60, 60, 120, 0.12);
            padding: 32px;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #5a3ea1;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
            background: #fff;
        }
        th, td {
            border: 1px solid #a3a3a3;
            padding: 12px 8px;
            text-align: center;
        }
        th {
            background: linear-gradient(90deg, #7f53ac 0%, #647dee 100%);
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background: #f3f0fa;
        }
        tr:hover {
            background: #e9e4f7;
        }
        @media print {
            body {
                background: #fff;
            }
            .report-container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                margin: 0;
            }
            table, th, td {
                border: 1px solid #333 !important;
            }
            th {
                background: #7f53ac !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <h1>Laporan Jurnal Harian</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnal as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($record->hari) }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->tanggal)->format('d M Y') }}</td>
                    <td>{{ $record->kegiatan }}</td>
                    <td>{{ $record->deskripsi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#888;">Tidak ada data jurnal harian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
