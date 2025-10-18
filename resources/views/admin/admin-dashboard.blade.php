<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard Admin</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#039BE5",
                        "background-light": "#F7F8FA",
                        "background-dark": "#1A202C",
                        "sidebar-light": "#03A9F4",
                        "sidebar-dark": "#0288D1",
                        "card-light": "#FFFFFF",
                        "card-dark": "#2D3748",
                        "text-light": "#4A5568",
                        "text-dark": "#CBD5E0",
                        "icon-bg-light": "#3F51B5",
                        "icon-bg-dark": "#3F51B5"
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark">
    <div class="flex h-screen">
        <aside class="w-64 bg-sidebar-light dark:bg-sidebar-dark text-white flex flex-col p-6">
            <div class="mb-8">
                <img src="{{ asset('assets/img/Combination Mark Logo - AMPEL.png') }}" alt="AMPEL Logo">
            </div>
            <!-- filepath: d:\applications\absensi\resources\views\admin\admin-dashboard.blade.php -->
            <div class="text-5xl font-bold mb-8" id="digital-clock">
                11:23:14
            </div>
            <nav class="flex-grow">
                <ul>
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/dashboardadmin">
                            <span class="material-icons mr-3">dashboard</span>
                            DASHBOARD
                        </a>
                    </li>
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/persetamagang">
                            <span class="material-icons mr-3">people</span>
                            PESERTA MAGANG
                        </a>
                    </li>
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors" href="/laporan">
                            <span class="material-icons mr-3">description</span>
                            LAPORAN
                        </a>
                    </li>
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors" href="#">
                            <span class="material-icons mr-3">schedule</span>
                            ABSENSI
                        </a>
                    </li>
                </ul>
            </nav>
            <div>
                <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                    href="{{ route('login') }}">
                    <span class="material-icons mr-3">logout</span>
                    LOG OUT
                </a>
            </div>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold text-text-light dark:text-text-dark mb-8">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md p-4 flex items-center">
                    <div class="bg-icon-bg-light dark:bg-icon-bg-dark p-4 rounded-md mr-4">
                        <span class="material-icons text-white text-3xl">person</span>
                    </div>
                    <div>
                        <p class="text-sm text-text-light dark:text-text-dark">ADMIN AKTIF</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">1</p>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md p-4 flex items-center">
                    <div class="bg-icon-bg-light dark:bg-icon-bg-dark p-4 rounded-md mr-4">
                        <span class="material-icons text-white text-3xl">groups</span>
                    </div>
                    <div>
                        <p class="text-sm text-text-light dark:text-text-dark">PESERTA MAGANG</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">36</p>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md p-4 flex items-center">
                    <div class="bg-icon-bg-light dark:bg-icon-bg-dark p-4 rounded-md mr-4">
                        <span class="material-icons text-white text-3xl">article</span>
                    </div>
                    <div>
                        <p class="text-sm text-text-light dark:text-text-dark">DATA LAPORAN</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">32</p>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md p-4 flex items-center">
                    <div class="bg-icon-bg-light dark:bg-icon-bg-dark p-4 rounded-md mr-4">
                        <span class="material-icons text-white text-3xl">history</span>
                    </div>
                    <div>
                        <p class="text-sm text-text-light dark:text-text-dark">DATA ABSENSI</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">14.355</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

<!-- Jam Digital -->
<script>
    function updateClock() {
        const now = new Date();
        const pad = n => n.toString().padStart(2, '0');
        const timeStr = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        document.getElementById('digital-clock').textContent = timeStr;
    }
    setInterval(updateClock, 1000);
    updateClock(); // Initial call to display the clock immediately
</script>

</html>
