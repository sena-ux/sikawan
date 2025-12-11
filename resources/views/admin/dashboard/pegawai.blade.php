@php
    $userId = auth()->id();

    $ijin = DB::table('t_izin')->where('user_id', $userId)->count();
    $hadir = DB::table('t_absensi')->where('user_id', $userId)->where('status', 'hadir')->count();
    $terlambat = DB::table('t_absensi')->where('user_id', $userId)->where('status', 'terlambat')->count();
    $TKehadiran = $hadir + $terlambat;
    $totalJurnal = DB::table('t_jurnal')->where('user_id', $userId)->count();
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

    {{-- <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengisian Jurnal</h3>
            </div>
            <div class="card-body">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <form id="leaveForm" class="space-y-4" enctype="multipart/form-data" method="post" action="{{ route('simpan.jurnal') }}">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" name="hari" id="hari">
                                <option value="">-- Pilih Hari --</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                                <option value="minggu">Minggu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" name="tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kegiatan</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Masukan kegiatan anda" name="kegiatan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="3"
                                placeholder="Detail pekerjaan yang di ambil ..." name="deskripsi"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Dokumentasi</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" type="file" name="foto" id="foto">
                            <small>*Opsional</small>
                        </div>
                        <button type="submit"
                            class="w-full bg-gradient-to-br from-purple-500 to-purple-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Simpan Jurnal Pekerjaan Harian Anda
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Action Buttons Section -->
    <hr>
    <div class="mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto w-full">
            <a href="{{ route('absensi') }}"
               class="flex items-center justify-center gap-3 w-full py-4 rounded-xl text-white text-lg font-semibold shadow-lg bg-gradient-to-br from-green-400 via-green-300 to-green-500 hover:from-green-500 hover:to-green-400 transition-all duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-7 4h10a2 2 0 002-2V7a2 2 0 00-2-2h-3V3h-2v2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Absensi
            </a>
            <a href="{{ route('main.jurnal') }}"
               class="flex items-center justify-center gap-3 w-full py-4 rounded-xl text-white text-lg font-semibold shadow-lg bg-gradient-to-br from-purple-400 via-pink-300 to-purple-500 hover:from-purple-500 hover:to-pink-400 transition-all duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                </svg>
                Jurnal Harian
            </a>
        </div>
    </div>
</div>
