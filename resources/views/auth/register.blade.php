<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Harian - Sistem Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            box-sizing: border-box;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            left: -9999px;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: #8b5cf6;
            background-color: #f9fafb;
        }

        .file-name {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }
    </style>
    <style>
        @view-transition {
            navigation: auto;
        }
    </style>
    <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
    <script src="/_sdk/element_sdk.js" type="text/javascript"></script>
</head>

<body class="bg-gray-50 min-h-screen"><!-- Header -->
    <header class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="px-4 lg:px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-gray-800">Form Registrasi Peserta</h1>
                    <p class="text-sm lg:text-base text-gray-600 hidden sm:block">Daftarkan diri Anda untuk mengakses
                        aplikasi</p>
                </div>
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-xs lg:text-sm text-gray-600" id="currentDate">Senin, 15 Januari 2024</p>
                        <p class="text-sm lg:text-lg font-semibold text-gray-800" id="currentTime">08:30:45</p>
                    </div><button onclick="goToDashboard()"
                        class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg><span class="hidden sm:inline font-semibold">Dashboard</span> </button>
                </div>
            </div>
        </div>
    </header><!-- Main Content -->
    <div class="p-4 sm:p-6 lg:p-8"><!-- Registration Card with Modern Responsive Design -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Registrasi Peserta</h3>
                            <p class="text-blue-100 text-sm mt-1">Lengkapi data diri Anda untuk mendaftar</p>
                        </div>
                    </div>
                </div><!-- Card Body -->
                <div class="p-6 sm:p-8">
                    <form id="registrationForm" class="space-y-5" method="post"><!-- Foto Profil Field (Optional) -->
                        <div class="fade-in"><label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg> Foto Profil <span
                                    class="ml-2 px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-md font-normal">Opsional</span>
                            </label>
                            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                <!-- Preview Photo -->
                                <div class="flex-shrink-0">
                                    <div id="photoPreview"
                                        class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center border-2 border-blue-200 overflow-hidden">
                                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div><!-- Upload Button -->
                                <div class="flex-1 w-full">
                                    <div class="file-upload-wrapper w-full"><input type="file" id="fotoProfile"
                                            name="fotoProfile" class="file-upload-input"
                                            accept="image/jpeg,image/png,image/jpg" onchange="previewPhoto(this)">
                                        <label for="fotoProfile" class="file-upload-label cursor-pointer">
                                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                                viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg><span class="text-sm text-gray-600">Klik untuk upload foto</span>
                                        </label>
                                    </div>
                                    <div id="photoFileName" class="file-name text-center"></div>
                                    <p class="text-xs text-gray-500 mt-2 text-center">Format: JPG, JPEG, PNG (Max 2MB)
                                    </p>
                                </div>
                            </div>
                        </div><!-- Nama Lengkap Field -->
                        <div class="fade-in"><label for="namaLengkap"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg> Nama Lengkap <span class="ml-1 text-red-500">*</span> </label> <input
                                type="text" id="namaLengkap" name="namaLengkap"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Masukkan nama lengkap Anda" required>
                        </div><!-- Grid for NIK and NIP -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5"><!-- NIK Field -->
                            <div class="fade-in"><label for="nik"
                                    class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewbox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg> NIK <span class="ml-1 text-red-500">*</span> <span
                                        class="ml-2 text-xs text-blue-600 font-normal">(Penting untuk masuk
                                        aplikasi)</span> </label> <input type="text" id="nik" name="nik"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    placeholder="16 digit NIK" maxlength="16" pattern="[0-9]{16}" required>
                            </div><!-- NIP Field -->
                            <div class="fade-in"><label for="nip"
                                    class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewbox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg> NIP <span
                                        class="ml-2 px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-md font-normal">Opsional</span>
                                </label> <input type="text" id="nip" name="nip"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    placeholder="Bagi yang punya silahkan dimasukkan">
                                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak memiliki NIP</p>
                            </div>
                        </div><!-- Email Field -->
                        <div class="fade-in"><label for="email"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg> Email <span class="ml-1 text-red-500">*</span> </label> <input type="email"
                                id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="contoh@email.com" required>
                        </div><!-- Jabatan Field -->
                        <div class="fade-in"><label for="jabatan"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg> Jabatan <span class="ml-1 text-red-500">*</span> </label> <input type="text"
                                id="jabatan" name="jabatan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Masukkan jabatan Anda" required>
                        </div><!-- Alamat Field -->
                        <div class="fade-in"><label for="alamat"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg> Alamat <span class="ml-1 text-red-500">*</span> </label>
                            <textarea id="alamat" name="alamat"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none"
                                rows="3" placeholder="Alamat tempat tinggal dalam kalimat singkat" required></textarea>
                            <p class="text-xs text-gray-500 mt-1">Contoh: Jl. Merdeka No. 123, Kelurahan ABC, Kecamatan
                                XYZ, Jakarta Selatan</p>
                        </div><!-- No HP Field -->
                        <div class="fade-in"><label for="noHp"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg> No HP <span class="ml-1 text-red-500">*</span> </label> <input type="tel"
                                id="noHp" name="noHp"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}" required>
                            <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx (10-13 digit)</p>
                        </div><!-- Required Fields Note -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Informasi Penting</p>
                                    <ul class="text-xs text-blue-700 mt-1 space-y-1 list-disc list-inside">
                                        <li>Semua field yang bertanda <span class="text-red-500 font-semibold">*</span>
                                            wajib diisi</li>
                                        <li><strong>NIK</strong> sangat penting untuk login ke aplikasi, pastikan data
                                            benar</li>
                                        <li><strong>NIP</strong> bersifat opsional, isi jika Anda memilikinya</li>
                                        <li>Pastikan email dan nomor HP yang dimasukkan aktif untuk keperluan komunikasi
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- Submit Button -->
                        <div class="pt-4"><button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 px-6 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg><span>Daftar Sekarang</span> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="successModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Berhasil!</h3>
            <p id="successMessage" class="text-gray-600 mb-4">Jurnal berhasil disimpan</p><button
                onclick="closeModal('successModal')"
                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                OK </button>
        </div>
    </div>
    <script>
        // Initialize app
        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);
        });

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


        function previewPhoto(input) {
            const preview = document.getElementById('photoPreview');
            const fileName = document.getElementById('photoFileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);

                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    fileName.textContent = 'Ukuran file terlalu besar! Maksimal 2MB';
                    fileName.style.color = '#ef4444';
                    input.value = '';
                    return;
                }

                // Check file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    fileName.textContent = 'Format file tidak valid! Gunakan JPG, JPEG, atau PNG';
                    fileName.style.color = '#ef4444';
                    input.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML =
                        `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
                    fileName.textContent = `${file.name} (${fileSize} MB)`;
                    fileName.style.color = '#059669';
                };

                reader.readAsDataURL(file);
            } else {
                // Reset to default icon
                preview.innerHTML = `
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                `;
                fileName.textContent = '';
            }
        }

        // Registration form handling
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const data = {
                fotoProfile: formData.get('fotoProfile')?.name || 'Tidak ada foto',
                namaLengkap: formData.get('namaLengkap'),
                nik: formData.get('nik'),
                nip: formData.get('nip') || 'Tidak ada',
                email: formData.get('email'),
                jabatan: formData.get('jabatan'),
                alamat: formData.get('alamat'),
                noHp: formData.get('noHp')
            };

            console.log('Data Pendaftaran:', data);

            // Show success message
            document.getElementById('successMessage').textContent =
                'Pendaftaran berhasil! Data Anda telah tersimpan dalam sistem.';
            showModal('successModal');

            // Reset form
            this.reset();

            // Reset photo preview
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `
                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            `;
            document.getElementById('photoFileName').textContent = '';
        });

        // File upload handler
        function updateFileName(input) {
            const fileName = document.getElementById('fileName');
            if (input.files && input.files.length > 0) {
                const file = input.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                fileName.textContent = `File terpilih: ${file.name} (${fileSize} MB)`;
            } else {
                fileName.textContent = '';
            }
        }

        // Modal functions
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'9ac43eeb935ea8cf',t:'MTc2NTQ0ODM4OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
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
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
</body>

</html>
