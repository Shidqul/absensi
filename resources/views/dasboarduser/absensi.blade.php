<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard Absensi</title>

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

        /* Container Main */
        main {
            min-height: calc(100vh - 90px);
            /* Atas */
            padding-top: 20px;
            /* Bawah */
            padding-bottom: 160px;
            /* Kiri */
            padding-left: 20px;
            /* Kanan */
            padding-right: 20px;
        }

        /* Timer Box Wrapper */
        .text-center>#digital-clock {
            background: white;
            padding: 40px 80px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
            font-family: 'Courier New', monospace;
            letter-spacing: 5px;
        }

        /* Dark mode untuk timer box */
        .dark .text-center>#digital-clock {
            background: #1f2937;
            color: #f9fafb;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        /* Hover effect untuk timer box */
        .text-center>#digital-clock:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .dark .text-center>#digital-clock:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
        }

        /* Responsive untuk tablet */
        @media (max-width: 768px) {
            main {
                padding: 40px 20px;
            }

            .text-center>#digital-clock {
                padding: 30px 40px;
                font-size: 3rem;
                letter-spacing: 3px;
            }
        }

        /* Responsive untuk mobile */
        @media (max-width: 480px) {
            main {
                padding: 20px 15px;
            }

            .text-center>#digital-clock {
                padding: 20px 30px;
                font-size: 2.25rem;
                letter-spacing: 2px;
            }

            .flex.justify-center.space-x-4 {
                flex-direction: column;
                gap: 1rem;
            }

            .flex.justify-center.space-x-4 a {
                width: 100%;
            }
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

        <main class="flex-grow flex items-center justify-center">
            <div class="text-center">
                <!-- Jam digital -->
                <div class="text-5xl font-bold mb-8" id="digital-clock">
                    07:46:23
                </div>
                <h2 class="text-4xl font-bold text-text-light dark:text-text-dark mb-2">Selamat Datang, Ragnar!</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Siap untuk memulai hari ini? Silakan catat kehadiran
                    Anda.</p>
                <div class="flex justify-center space-x-4">
                    <a class="bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-12 rounded-lg shadow-md transition-all duration-300"
                        href="#">
                        Masuk
                    </a>
                    <a class="bg-button-disabled-light dark:bg-button-disabled-dark text-button-text-disabled-light dark:text-button-text-disabled-dark font-semibold py-3 px-12 rounded-lg cursor-pointer"
                        href="#">
                        Pulang
                    </a>
                </div>
            </div>
        </main>

    </div>

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
