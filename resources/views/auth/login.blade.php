<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKAWAN</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/icons/logo.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="{{ asset('admin/assets/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/assets/sweetalert/package/dist/sweetalert2.all.js') }}"></script>
</head>

<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

        <div class="flex flex-col lg:flex-row bg-white/95 backdrop-blur-2xl shadow-2xl rounded-3xl overflow-hidden w-full max-w-6xl animate-fadeIn">

            <!-- IMAGE / ILLUSTRATION -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 relative overflow-hidden items-center justify-center p-8">

                <!-- Decorative Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 right-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 left-10 w-40 h-40 bg-blue-300 rounded-full blur-3xl"></div>
                </div>

                <!-- Image Container dengan aspect ratio 16:9 -->
                <div class="relative w-full h-full flex items-center justify-center z-10">
                    <img src="{{ asset('admin/assets/icons/timeline.png') }}" alt="Illustration"
                        class="w-5/5 h-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Overlay Text -->
                <div class="absolute bottom-8 left-8 right-8 text-white z-20">
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang</h2>
                    <p class="text-blue-100 text-sm">Sistem Informasi Kepegawaian dan Absensi Smandapura Berbasis Web</p>
                </div>
            </div>

            <!-- LOGIN PANEL -->
            <div class="w-full lg:w-1/2 p-8 sm:p-10 lg:p-12 flex flex-col justify-center">

                <!-- LOGO -->
                <div class="text-center mb-10">
                    <div class="inline-block bg-gradient-to-br from-blue-600 to-blue-700 w-20 h-20 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 mb-4 mx-auto">
                        <img src="{{ asset('admin/assets/icons/android-chrome-512x512.png') }}" alt="logo" class="w-12">
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-2">
                        SIKAWAN
                    </h1>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <i>Sistem Informasi Kepegawaian dan Absensi</i>
                    </p>
                </div>

                <!-- Welcome Text -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk Ke Akun Anda</h2>
                    <p class="text-gray-600 text-sm">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                </div>

                <!-- FORM -->
                <form id="loginForm" class="space-y-6">
                    @csrf

                    <!-- USERNAME -->
                    <div class="group">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                        <div class="relative">
                            <input type="text" id="username" name="username" required placeholder="Masukkan username Anda"
                                class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl shadow-sm
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                      transition-all duration-300 group-hover:border-blue-300">
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="Masukkan password Anda"
                                class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl shadow-sm
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                      transition-all duration-300 group-hover:border-blue-300">
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl font-semibold
                           hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl
                           transition-all duration-300 transform hover:-translate-y-1
                           active:scale-95 mt-8">
                        Masuk
                    </button>

                </form>

                <!-- Footer -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600 text-xs">© 2024 SIKAWAN - Smandapura</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ANIMATION -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Memproses...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('login.post') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Login Berhasil",
                            text: "Selamat datang kembali!",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON.message ??
                                "Terjadi kesalahan koneksi ke server!"
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
