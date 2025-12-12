@php
    $userId = auth()->id();

    $ijin = DB::table('t_izin')->where('user_id', $userId)->count();
    $hadir = DB::table('t_absensi')->where('user_id', $userId)->where('status', 'hadir')->count();
    $terlambat = DB::table('t_absensi')->where('user_id', $userId)->where('status', 'terlambat')->count();
    $TKehadiran = $hadir + $terlambat;
    $totalJurnal = DB::table('t_jurnal')->where('user_id', $userId)->count();

    $today = now()->toDateString();

    // Cek absensi hari ini
    $absensiHariIni = DB::table('t_absensi')
        ->where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->exists();

    // Cek jurnal hari ini
    $jurnalHariIni = DB::table('t_jurnal')
        ->where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->exists();

    // Hitung progres
    if ($absensiHariIni && $jurnalHariIni) {
        $progres = 100;
    } elseif ($absensiHariIni && !$jurnalHariIni) {
        $progres = 50;
    } else {
        $progres = 0;
    }

@endphp

<!-- Dashboard Section -->
<div id="dashboardSection" class="p-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Kehadiran</p>
                    <p class="text-3xl font-bold">{{ $TKehadiran }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Hadir</p>
                    <p class="text-3xl font-bold">{{ $hadir }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Terlambat</p>
                    <p class="text-3xl font-bold">{{ $terlambat }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Izin/Cuti</p>
                    <p class="text-3xl font-bold">{{ $ijin }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Jurnal</p>
                    <p class="text-3xl font-bold">{{ $totalJurnal }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="mt-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Akses Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-7 4h10a2 2 0 002-2V7a2 2 0 00-2-2h-3V3h-2v2H7a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Absensi</h4>
                    <p class="text-gray-600 text-sm mb-4">Catat kehadiran dan jam kerja anda</p>
                    <button onclick="window.location='{{ route('absensi') }}'"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Buka Absensi
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Jurnal Harian</h4>
                    <p class="text-gray-600 text-sm mb-4">Buat laporan kegiatan harian anda</p>
                    <button onclick="window.location='{{ route('main.jurnal') }}'"
                        class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200">
                        Isi Jurnal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="mt-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Progres Pekerjaan Harian</h3>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="mb-4">
                <p class="text-gray-700 font-medium mb-2">Progres Hari Ini: {{ $progres }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full transition-all duration-500"
                        style="width: {{ $progres }}%">
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-600">
                @if($progres == 100)
                    ✅ Absensi dan Jurnal sudah lengkap hari ini.
                @elseif($progres == 50)
                    ⚠️ Absensi sudah diisi, jangan lupa buat Jurnal Harian.
                @else
                    ❌ Belum ada absensi maupun jurnal hari ini.
                @endif
            </p>
        </div>
    </div>

</div>
