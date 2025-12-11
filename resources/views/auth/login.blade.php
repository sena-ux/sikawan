<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/icons/logo.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="{{ asset('admin/assets/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/assets/sweetalert/package/dist/sweetalert2.all.js') }}"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-[#c8a47b">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-orange-100 p-4">

        <div
            class="flex flex-col md:flex-row bg-white/80 backdrop-blur-xl shadow-2xl rounded-2xl overflow-hidden w-full max-w-5xl animate-fadeIn">

            <!-- IMAGE / ILLUSTRATION -->
            <div class="hidden md:block w-1/2 bg-[#c8a47b] p-4 flex items-center justify-center">
                <img src="{{ asset('admin/assets/icons/timeline.png') }}" alt="Thumbnail"
                    class="w-full h-auto drop-shadow-lg">
            </div>

            <!-- LOGIN PANEL -->
            <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">

                <!-- LOGO -->
                <div class="text-center mb-8">
                    <div
                        class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto shadow-md hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('admin/assets/icons/android-chrome-512x512.png') }}" alt="logo"
                            class="w-10">
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mt-4 tracking-wide">APLIKASI SIKAWAN</h1>
                    <small class="text-gray-600 block mt-1"><i>Sistem Informasi Kepegawaian dan Absensi Smandapura
                            Berbasis Web</i></small>
                </div>

                <!-- FORM -->
                <form id="loginForm" class="space-y-5">
                    @csrf

                    <!-- USERNAME -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                  transition-all duration-200">
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none 
                                  transition-all duration-200">
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold 
                           hover:bg-blue-700 shadow-lg hover:shadow-xl
                           transition-all duration-300 transform hover:-translate-y-0.5">
                        Masuk
                    </button>

                </form>
            </div>
        </div>
    </div>

    <!-- ANIMATION -->
    <style>
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

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
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
