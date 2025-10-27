<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard Home</title>

    {{-- ✅ Favicon --}}
    @include('partials.favicon')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0095E8",
                        "background-light": "#FFFFFF",
                        "background-dark": "#121212",
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E1E1E",
                        "text-light": "#1F2937",
                        "text-dark": "#F3F4F6",
                        "subtext-light": "#6B7280",
                        "subtext-dark": "#9CA3AF",
                        "border-light": "#E5E7EB",
                        "border-dark": "#374151"
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .nav-active {
            color: #0095E8 !important;
            font-weight: 600 !important;
        }

        /* header shadow */
        .header-full-line {
            position: relative;
        }

        .header-full-line::after {
            content: '';
            position: absolute;
            /* Sedikit ke bawah untuk efek shadow */
            bottom: -2px;
            left: 0;
            right: 0;
            width: 100vw;
            height: 4px;
            background: transparent;
            /* Blur shadow */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-left: calc(-50vw + 50%);
        }

        /* Dark mode */
        .dark .header-full-line::after {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark">
    <div class="min-h-screen container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="mb-12 pb-6 header-full-line">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/img/Logo PT Pelindo (Symbol Only).png') }}" alt="Pelindo Logo"
                        class="h-8 w-auto">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('assets/img/Combination Mark Logo - AMPEL.png') }}" alt="AMPEL Logo"
                            class="h-8 w-auto">
                    </div>
                </div>

                <!-- Desktop Navbar -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="/dashboard"
                        class="nav-link text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                        Home
                    </a>
                    <a href="/absensi"
                        class="nav-link text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                        Absensi
                    </a>
                    <a href="/laporankegiatan"
                        class="nav-link text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                        Laporan
                    </a>
                </nav>

                <!-- Profil -->
                <div class="flex items-center">
                    <div class="relative">
                        <button id="profile-button"
                            class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xl">
                            R
                        </button>

                        <!-- Dropdown Desktop -->
                        <div id="profile-dropdown-desktop"
                            class="hidden absolute right-0 mt-2 w-48 bg-card-light dark:bg-card-dark rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                            <a href="#"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-icons mr-3 text-base">person_outline</span> Profil Saya
                            </a>
                            <a href="{{ route('login') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-icons mr-3 text-base">logout</span> Log out
                            </a>
                        </div>

                        <!-- Dropdown Mobile -->
                        <div id="profile-dropdown-mobile"
                            class="hidden absolute right-0 mt-2 w-64 bg-card-light dark:bg-card-dark rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 md:hidden">
                            <div class="border-b border-border-light dark:border-border-dark">
                                <a href="/dashboard"
                                    class="mobile-link flex items-center px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-icons mr-3 text-base">home</span> Home
                                </a>
                                <a href="/absensi"
                                    class="mobile-link flex items-center px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-icons mr-3 text-base">event_available</span> Absensi
                                </a>
                                <a href="/laporankegiatan"
                                    class="mobile-link flex items-center px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-icons mr-3 text-base">description</span> Laporan
                                </a>
                            </div>
                            <div>
                                <a href="#"
                                    class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-icons mr-3 text-base">person_outline</span> Profil Saya
                                </a>
                                <a href="{{ route('login') }}"
                                    class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-icons mr-3 text-base">logout</span> Log out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Container home -->
        <main>
            <section class="text-center mb-12">
                <h1 class="text-3xl font-bold mb-2 text-text-light dark:text-text-dark">Selamat Datang, Ragnar!</h1>
                <p class="text-subtext-light dark:text-subtext-dark">Siap untuk memulai hari ini? Silakan catat
                    kehadiran Anda.</p>
                <button onclick="window.location.href='/absensi'"
                    class="mt-6 bg-primary text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-600 transition-colors">
                    Absen Hari Ini
                </button>
            </section>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-card-light dark:bg-card-dark p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-light dark:text-text-dark">Riwayat Kehadiran</h2>
                        <a class="text-primary text-sm font-medium hover:underline" href="#">Lihat
                            Selengkapnya</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark">Senin, 15 Juli 2026</p>
                                <p class="text-sm text-subtext-light dark:text-subtext-dark">07:40 MASUK 17:10 PULANG
                                </p>
                            </div>
                            <span class="text-green-500 font-semibold">Hadir</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark">Selasa, 16 Juli 2026</p>
                                <p class="text-sm text-subtext-light dark:text-subtext-dark">-</p>
                            </div>
                            <span class="text-yellow-500 font-semibold">Izin</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark">Rabu, 17 Juli 2026</p>
                                <p class="text-sm text-subtext-light dark:text-subtext-dark">-</p>
                            </div>
                            <span class="text-red-500 font-semibold">Tidak Hadir</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark">Kamis, 18 Juli 2026</p>
                                <p class="text-sm text-subtext-light dark:text-subtext-dark">07:36 MASUK 17:13 PULANG
                                </p>
                            </div>
                            <span class="text-green-500 font-semibold">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-6 text-text-light dark:text-text-dark">Ringkasan Kehadiran</h2>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-100 dark:bg-gray-800/50 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-green-500">20</p>
                            <p class="text-sm text-subtext-light dark:text-subtext-dark">Hadir</p>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-800/50 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-red-500">2</p>
                            <p class="text-sm text-subtext-light dark:text-subtext-dark">Tidak Hadir</p>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-800/50 p-4 rounded-lg text-center col-span-2">
                            <p class="text-3xl font-bold text-yellow-500">1</p>
                            <p class="text-sm text-subtext-light dark:text-subtext-dark">Izin</p>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold mb-4 text-text-light dark:text-text-dark">Pengajuan</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex-1 bg-primary text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-colors">
                            Ajukan Izin
                        </button>
                        <button
                            class="flex-1 border border-primary text-primary font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                            Riwayat Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <!-- Dropdown Combination -->
    <script>
        // === Dropdown ===
        const profileButton = document.getElementById('profile-button');
        const profileDropdownDesktop = document.getElementById('profile-dropdown-desktop');
        const profileDropdownMobile = document.getElementById('profile-dropdown-mobile');

        const isMobile = () => window.innerWidth < 768;

        profileButton.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isMobile()) {
                profileDropdownMobile.classList.toggle('hidden');
                profileDropdownDesktop.classList.add('hidden');
            } else {
                profileDropdownDesktop.classList.toggle('hidden');
                profileDropdownMobile.classList.add('hidden');
            }
        });

        document.addEventListener('click', (event) => {
            if (!profileButton.contains(event.target) &&
                !profileDropdownDesktop.contains(event.target) &&
                !profileDropdownMobile.contains(event.target)) {
                profileDropdownDesktop.classList.add('hidden');
                profileDropdownMobile.classList.add('hidden');
            }
        });

        window.addEventListener('resize', () => {
            profileDropdownDesktop.classList.add('hidden');
            profileDropdownMobile.classList.add('hidden');
        });

        // === Aktifkan link navbar sesuai halaman ===
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        function setActiveLink(links) {
            links.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (currentPath.startsWith(linkPath)) {
                    link.classList.add('nav-active');
                } else {
                    link.classList.remove('nav-active');
                }
            });
        }

        setActiveLink(navLinks);
        setActiveLink(mobileLinks);
    </script>
</body>

</html>
