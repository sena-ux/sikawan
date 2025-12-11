<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Harian - Sistem Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="{{ asset('admin/assets/icons/logo.ico') }}" type="image/x-icon">
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
</head>

<body class="bg-gray-50 min-h-screen"><!-- Header -->
    <header class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="px-4 lg:px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-gray-800">Pengisian Jurnal Harian</h1>
                    <p class="text-sm lg:text-base text-gray-600 hidden sm:block">Catat aktivitas pekerjaan harian Anda
                    </p>
                </div>
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-xs lg:text-sm text-gray-600" id="currentDate">Senin, 15 Januari 2024</p>
                        <p class="text-sm lg:text-lg font-semibold text-gray-800" id="currentTime">08:30:45</p>
                    </div><button onclick="window.location.href='{{ route('jurnal.data') }}'"
                        class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg><span class="hidden sm:inline font-semibold">Kembali</span>
                    </button>
                </div>
            </div>
        </div>
    </header><!-- Main Content -->
    <div class="p-4 sm:p-6 lg:p-8"><!-- Journal Card with Modern Responsive Design -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Pengisian Jurnal Harian</h3>
                            <p class="text-purple-100 text-sm mt-1">Catat aktivitas pekerjaan harian Anda</p>
                        </div>
                    </div>
                </div><!-- Card Body -->
                <div class="p-6 sm:p-8">
                    <form id="leaveForm" class="space-y-5" enctype="multipart/form-data" method="post"
                        action="{{ route('simpan.jurnal') }}">
                        @csrf
                        <!-- Hari Field -->
                        <div class="fade-in"><label for="hari"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg> Hari <span class="ml-1 text-red-500">*</span> </label> <select
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                name="hari" id="hari" required>
                                <option value="">-- Pilih Hari --</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                                <option value="minggu">Minggu</option>
                            </select>
                        </div><!-- Tanggal Field -->
                        <div class="fade-in"><label for="tanggal"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg> Tanggal <span class="ml-1 text-red-500">*</span> </label> <input type="date"
                                id="tanggal"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                name="tanggal" required>
                        </div><!-- Kegiatan Field -->
                        <div class="fade-in"><label for="kegiatan"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg> Kegiatan <span class="ml-1 text-red-500">*</span> </label> <input type="text"
                                id="kegiatan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Masukan kegiatan anda" name="kegiatan" required>
                        </div><!-- Deskripsi Field -->
                        <div class="fade-in"><label for="deskripsi"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16m-7 6h7" />
                                </svg> Deskripsi <span class="ml-1 text-red-500">*</span> </label> <textarea
                                id="deskripsi"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none"
                                rows="4" placeholder="Detail pekerjaan yang diambil..." name="deskripsi"
                                required></textarea>
                        </div><!-- Foto Dokumentasi Field -->
                        <div class="fade-in"><label for="foto"
                                class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg> Foto Dokumentasi <span
                                    class="ml-2 px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-md font-normal">Opsional</span>
                            </label>
                            <div class="file-upload-wrapper"><input type="file" id="foto" name="foto" accept="image/*"
                                    class="file-upload-input" onchange="updateFileName(this)"> <label for="foto"
                                    class="file-upload-label">
                                    <div class="text-center w-full">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none"
                                            stroke="currentColor" viewbox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <div class="text-sm text-gray-600"><span
                                                class="font-medium text-purple-600 hover:text-purple-500">Klik untuk
                                                upload</span> <span class="hidden sm:inline"> atau drag and drop</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG hingga 5MB</p>
                                    </div>
                                </label>
                            </div>
                            <div id="fileName" class="file-name"></div>
                        </div><!-- Required Fields Note -->
                        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-purple-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-purple-800">Informasi Pengisian</p>
                                    <p class="text-xs text-purple-700 mt-1">Semua field yang bertanda <span
                                            class="text-red-500">*</span> wajib diisi. Foto dokumentasi bersifat
                                        opsional dan dapat diisi sesuai kebutuhan.</p>
                                </div>
                            </div>
                        </div><!-- Submit Button -->
                        <div class="pt-4"><button type="submit"
                                class="w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white py-4 px-6 rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg><span>Simpan Jurnal Harian</span> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize app
        document.addEventListener('DOMContentLoaded', function () {
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

        // Journal form handling
        $('#leaveForm').on('submit', function (e) {
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
                        text: 'Jurnal berhasil disimpan!',
                        confirmButtonColor: '#8b5cf6'
                    });
                    form.reset();
                    $('#fileName').text('');
                },
                error: function (xhr) {
                    let msg = 'Terjadi kesalahan saat menyimpan jurnal.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'9a8219fec5f0fddf',t:'MTc2NDc1NDgxNi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
</body>

</html>
