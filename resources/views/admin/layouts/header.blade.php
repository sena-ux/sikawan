<header class="bg-white shadow-sm border-b sticky top-0 z-40">
    <div class="px-4 lg:px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="ml-12 lg:ml-0">
                <h1 class="text-2xl font-bold text-gray-800" id="pageTitle">@yield('pageTitle')</h1>
                <p class="text-gray-600" id="pageSubtitle">@yield('pageSubTitle')</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm text-gray-600" id="currentDate">Senin, 15 Januari 2024</p>
                    <p class="text-lg font-semibold text-gray-800" id="currentTime">08:30:45</p>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-2 lg:p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5v-5zM4 19h5v-5H4v5zM13 13h5l-5 5v-5zM4 13h5V8H4v5zM13 7h5l-5 5V7zM4 7h5V2H4v5z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</header>
