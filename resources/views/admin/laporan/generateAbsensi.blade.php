<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
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
            max-width: 1000px;
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
        .status-hadir {
            color: #22c55e;
            font-weight: 600;
        }
        .status-terlambat {
            color: #eab308;
            font-weight: 600;
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
        <h1>Laporan Kehadiran Pegawai</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>NIK</th>
                    <th>NIP</th>
                    @php
                        // Ambil semua tanggal unik dari data absensi
                        $tanggalList = collect($data)->pluck('tanggal')->unique()->sort();
                    @endphp
                    @forelse($tanggalList as $tanggal)
                        <th>{{ \Carbon\Carbon::parse($tanggal)->format('d/m') }}</th>
                    @empty
                        <th>-</th>
                    @endforelse
                </tr>
            </thead>
            <tbody>
                @php
                    // Group data by pegawai
                    $data = collect($data)->groupBy('user_id');
                @endphp
                @forelse($data as $userId => $absensiByUser)
                    @php
                        $pegawai = $absensiByUser->first()->pegawai;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pegawai->nama_lengkap }}</td>
                        <td>{{ $pegawai->nik }}</td>
                        <td>{{ $pegawai->nip }}</td>
                        @foreach($tanggalList as $tanggal)
                            @php
                                $absensiTanggal = $absensiByUser->firstWhere('tanggal', $tanggal);
                            @endphp
                            <td>
                                @if($absensiTanggal)
                                    <span class="status-{{ $absensiTanggal->status }}">
                                        @if($absensiTanggal->status == 'hadir')
                                            ✓
                                        @elseif($absensiTanggal->status == 'terlambat')
                                            T
                                        @else
                                            -
                                        @endif
                                    </span>
                                @else
                                    <span style="color:#888;">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" style="text-align:center;color:#888;">Tidak ada data absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
