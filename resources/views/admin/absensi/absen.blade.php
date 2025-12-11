<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi Pegawai</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/icons/logo.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            box-sizing: border-box;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Employee Dashboard -->
    <div id="employeeDashboard">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <div class="bg-blue-600 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-semibold text-gray-800 hidden lg:block">Presensi Pegawai</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Selamat datang, {{ auth()->user()->pegawai->nama_lengkap }}</span>
                        <button onclick="window.location.href='{{ route('dashboard') }}'"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                            Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Employee Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Views Maps</h3>
                <div class="overflow-x-auto">
                    <div id="maps" style="height: 400px; border-radius: 12px;"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Check In/Out Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Presensi Hari Ini</h3>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-800 mb-2" id="currentTime">08:30:45</div>
                        <div class="text-gray-600 mb-6" id="currentDate">Senin, 15 Januari 2024</div>

                        <div id="checkInSection" class="mb-4">
                            <button onclick="checkIn()"
                                class="w-full bg-green-600 text-white py-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium pulse-animation">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Check In
                            </button>
                        </div>

                        <div id="checkOutSection" class="hidden mb-4">
                            <div class="bg-green-50 p-4 rounded-lg mb-4">
                                <p class="text-green-800 font-medium">✓ Check In: 08:15 WIB</p>
                            </div>
                            <button onclick="checkOut()"
                                class="w-full bg-red-600 text-white py-4 rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Check Out
                            </button>
                        </div>

                        <div id="completedSection" class="hidden">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-blue-800 font-medium">✓ Check In: 08:15 WIB</p>
                                <p class="text-blue-800 font-medium">✓ Check Out: 17:30 WIB</p>
                                <p class="text-sm text-blue-600 mt-2">Kerja hari ini selesai!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave Request -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengajuan Izin/Cuti</h3>
                    <form id="formIzin" class="space-y-4" method="post" enctype="multipart/form-data" action="{{ route('absensi.izin') }}">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                            <select name="jenis"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="Izin Sakit">Izin Sakit</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Izin Pribadi">Izin Pribadi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" name="tanggal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea name="keterangan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                rows="3" placeholder="Alasan izin/cuti..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen</label>
                            <input type="file" name="dokumen" id="dokumen"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Ajukan Izin
                        </button>
                    </form>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Kehadiran</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam Masuk</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam Pulang</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($absensi as $absen)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $absen->jam_masuk ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $absen->jam_pulang ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($absen->status == 'hadir')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                        @elseif($absen->status == 'terlambat')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Terlambat</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($absen->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($absen->jam_masuk && $absen->jam_pulang)
                                            @php
                                                $start = \Carbon\Carbon::parse($absen->jam_masuk);
                                                $end = \Carbon\Carbon::parse($absen->jam_pulang);
                                                $diff = $end->diff($start);
                                            @endphp
                                            {{ $diff->h }}j {{ $diff->i }}m
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kehadiran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Leave History Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Ketidakhadiran (Izin/Cuti)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($izin as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status == 'approved')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif($item->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data izin/cuti.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Modal -->
    <div id="locationModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Lokasi</h3>
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-600">Memverifikasi lokasi Anda...</p>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Berhasil!</h3>
            <p id="successMessage" class="text-gray-600 mb-4">Presensi berhasil dicatat</p>
            <button onclick="closeModal('successModal')"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                OK
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Initialize app
        document.addEventListener('DOMContentLoaded', function () {
            updateTime();
            setInterval(updateTime, 1000);
            initializeApp();
            setInterval(initializeApp, 30000);
        });

        // Initialize app
        function initializeApp() {
            // Koordinat kantor
            const officeLat = -8.409518;
            const officeLng = 115.188919;
            const maxDistance = 100; // meter

            // Fungsi menghitung jarak (Haversine formula)
            function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // radius bumi (meter)
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            // Inisialisasi peta
            const map = L.map('maps').setView([officeLat, officeLng], 17);

            // Tambahkan tile layer (peta dasar)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marker kantor
            const officeMarker = L.marker([officeLat, officeLng])
                .addTo(map)
                .bindPopup('<b>Kantor</b><br>Area absensi utama');

            // Lingkaran radius absensi
            const officeCircle = L.circle([officeLat, officeLng], {
                color: 'blue',
                fillColor: '#3b82f6',
                fillOpacity: 0.2,
                radius: maxDistance
            }).addTo(map);

            // Dapatkan lokasi user
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const distance = getDistanceFromLatLonInMeters(userLat, userLng, officeLat, officeLng);

                    // Tambahkan marker posisi user
                    const userMarker = L.marker([userLat, userLng], {
                        icon: L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/64/64113.png',
                            iconSize: [32, 32],
                            iconAnchor: [16, 32]
                        })
                    }).addTo(map)
                        .bindPopup(`<b>Posisi Anda</b><br>Jarak ke kantor: ${distance.toFixed(2)} meter`);

                    // Fokuskan peta agar terlihat semua
                    const bounds = L.latLngBounds([
                        [userLat, userLng],
                        [officeLat, officeLng]
                    ]);
                    map.fitBounds(bounds, {
                        padding: [50, 50]
                    });

                    // Tampilkan notifikasi
                    if (distance <= maxDistance) {
                        userMarker.bindPopup(
                            `<b>Anda berada di area absensi!</b><br>Jarak: ${distance.toFixed(2)} m`)
                            .openPopup();
                    } else {
                        userMarker.bindPopup(`<b>Anda di luar area absensi!</b><br>Jarak: ${distance.toFixed(2)} m`)
                            .openPopup();
                    }

                }, () => {
                    alert("Gagal mendapatkan lokasi Anda.");
                });
            } else {
                alert("Browser Anda tidak mendukung geolokasi.");
            }
        }

        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const timeElement = document.getElementById('currentTime');
            const dateElement = document.getElementById('currentDate');

            if (timeElement) timeElement.textContent = timeString;
            if (dateElement) dateElement.textContent = dateString;
        }

        // Check-in functionality
        function checkIn() {
            showModal('locationModal');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        // 🔹 Ganti dengan koordinat kantor kamu
                        const officeLat = -8.409518;
                        const officeLng = 115.188919;
                        const maxDistance = 100; // meter

                        const distance = getDistanceFromLatLonInMeters(userLat, userLng, officeLat, officeLng);

                        if (distance <= maxDistance) {
                            // Kirim ke server
                            fetch("/absensi/masuk", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    latitude: userLat,
                                    longitude: userLng
                                })
                            })
                                .then(res => res.json())
                                .then(() => data => {
                                    Swal.fire({
                                        icon: data.status === 'success' ? 'success' : 'error',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                })
                                .catch(() => {
                                    Swal.fire("Error", "Terjadi kesalahan server!", "error");
                                });
                        } else {
                            closeModal('locationModal');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Diluar Area!',
                                text: `Anda berada di luar radius kantor (${distance.toFixed(1)} m)`,
                            });
                        }
                    },
                    function () {
                        closeModal('locationModal');
                        Swal.fire("Error", "Tidak dapat mengambil lokasi. Pastikan GPS aktif!", "error");
                    }, {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
                );
            } else {
                Swal.fire("Error", "Browser tidak mendukung GPS.", "error");
            }
        }

        // 🔹 Fungsi untuk menghitung jarak antar dua titik (Haversine Formula)
        function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // radius bumi dalam meter
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }



        function completeCheckIn() {
            attendanceStatus = 'checked_in';
            document.getElementById('checkInSection').classList.add('hidden');
            document.getElementById('checkOutSection').classList.remove('hidden');

            document.getElementById('successMessage').textContent = 'Check-in berhasil! Lokasi terverifikasi.';
            showModal('successModal');

            // Simulate notification
            console.log('Notifikasi dikirim: Check-in berhasil pada ' + new Date().toLocaleTimeString());
        }

        // Check-out functionality
        // function checkOut() {
        //     showModal('locationModal');

        //     setTimeout(() => {
        //         closeModal('locationModal');
        //         completeCheckOut();
        //     }, 1500);
        // }

        function checkOut() {
            showModal('locationModal');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        const officeLat = -8.409518;
                        const officeLng = 115.188919;
                        const maxDistance = 100;

                        const distance = getDistanceFromLatLonInMeters(userLat, userLng, officeLat, officeLng);

                        if (distance <= maxDistance) {
                            fetch("/absensi/pulang", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    latitude: userLat,
                                    longitude: userLng
                                })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: data.status === 'success' ? 'success' : 'error',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                })
                                .catch(() => {
                                    Swal.fire("Error", "Terjadi kesalahan server!", "error");
                                });
                        } else {
                            closeModal('locationModal');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Diluar Area!',
                                text: `Anda berada di luar radius kantor (${distance.toFixed(1)} m)`,
                            });
                        }
                    },
                    function () {
                        closeModal('locationModal');
                        Swal.fire("Error", "Tidak dapat mengambil lokasi. Pastikan GPS aktif!", "error");
                    }, {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
                );
            } else {
                Swal.fire("Error", "Browser tidak mendukung GPS.", "error");
            }
        }


        function completeCheckOut() {
            attendanceStatus = 'checked_out';
            document.getElementById('checkOutSection').classList.add('hidden');
            document.getElementById('completedSection').classList.remove('hidden');

            document.getElementById('successMessage').textContent =
                'Check-out berhasil! Terima kasih atas kerja keras Anda hari ini.';
            showModal('successModal');

            // Simulate notification
            console.log('Notifikasi dikirim: Check-out berhasil pada ' + new Date().toLocaleTimeString());
        }

        // Leave request form
        // document.getElementById('formIzin').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     document.getElementById('successMessage').textContent =
        //         'Pengajuan izin berhasil dikirim dan menunggu persetujuan admin.';
        //     showModal('successModal');

        //     // Reset form
        //     this.reset();
        // });

        // Modal functions
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Export functions (demo)
        function exportToExcel() {
            alert('Fitur export Excel akan mengunduh file laporan presensi dalam format .xlsx');
        }

        function exportToPDF() {
            alert('Fitur export PDF akan mengunduh file laporan presensi dalam format .pdf');
        }

        // Initialize attendance chart
        function initializeChart() {
            const ctx = document.getElementById('attendanceChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Hadir',
                        data: [28, 29, 27, 30, 26, 15, 8],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Terlambat',
                        data: [2, 1, 3, 0, 4, 1, 0],
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        $('#formIzin').on('submit', function (e) {
            e.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pengajuan izin berhasil dikirim dan menunggu persetujuan admin.',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        location.reload();
                    });
                    form.reset();
                },
                error: function (xhr) {
                    let msg = 'Terjadi kesalahan saat mengajukan izin.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors).join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: msg,
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });
    </script>
    <script>
        (function () {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'9891cd02a0016034',t:'MTc1OTU1MDcyNS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function () { };
                    document.onreadystatechange = function (b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
</body>

</html>
