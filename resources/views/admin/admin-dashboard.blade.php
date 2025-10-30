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

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: #f5f5f5;
        }

        /* Grid Layout for Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Responsive: Stack cards on smaller screens */
        @media (max-width: 968px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card Container */
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Card Header */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        /* Dropdown Select */
        .dropdown {
            padding: 8px 30px 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
            width: auto;
            /* Biarkan auto agar menyesuaikan konten */
            min-width: 110px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }


        /* Pastikan option mengikuti lebar dropdown */
        .dropdown option {
            padding: 8px;
            font-size: 13px;
        }

        .dropdown:hover {
            border-color: #4da6ff;
        }

        .dropdown:focus {
            border-color: #4da6ff;
            box-shadow: 0 0 0 2px rgba(77, 166, 255, 0.1);
        }

        /* Card Content */
        .card-content {
            text-align: center;
            padding: 20px 0;

        }

        /* Big Number Display */
        .big-number {
            font-size: 64px;
            font-weight: 300;
            color: #4da6ff;
            margin-bottom: 10px;
            line-height: 1;
        }

        /* Label Text */
        .label {
            color: #666;
            font-size: 14px;
            font-weight: 400;
        }

        /* Stats Grid (for Absensi card) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Individual Stat Box */
        .stat-box {
            text-align: center;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .stat-box:hover {
            background: #f9f9f9;
        }


        /* Stat Number */
        .stat-number {
            font-size: 48px;
            font-weight: 300;
            margin-bottom: 8px;
            line-height: 1;
        }

        /* Color Variations */
        .stat-number.green {
            color: #5cb85c;
        }

        .stat-number.red {
            color: #d9534f;
        }

        /* Stat Label */
        .stat-label {
            color: #666;
            font-size: 14px;
            font-weight: 400;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }

            .grid {
                gap: 15px;
            }

            .card {
                padding: 20px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .dropdown {
                width: 100%;
            }

            .big-number {
                font-size: 48px;
            }

            .stat-number {
                font-size: 36px;
            }

            .stats-grid {
                gap: 10px;
            }

            .stat-box {
                padding: 15px;
            }
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
                    <!-- Dashboard -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/dashboardadmin">
                            <span class="material-icons mr-3">dashboard</span>
                            DASHBOARD
                        </a>
                    </li>
                    <!-- Peserta Magang -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/persetamagang">
                            <span class="material-icons mr-3">people</span>
                            PESERTA MAGANG
                        </a>
                    </li>
                    <!-- Data Divisi -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors" href="">
                            <span class="material-icons mr-3">badge</span>
                            DATA DiVISI
                        </a>
                    </li>
                    <!-- Laporan -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors" href="/laporan">
                            <span class="material-icons mr-3">description</span>
                            LAPORAN
                        </a>
                    </li>
                    <!-- Absensi -->
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
        <div class="main-content">
            <div class="grid">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Jumlah Peserta Magang</h2>
                    </div>
                    <div class="card-content"
                        style="padding: 30px 20px; background: #f9f9f9; border-radius: 6px; margin: 10px 0;">
                        <div class="big-number">36</div>
                        <div class="label">Peserta</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Data Divisi</h2>
                        <select class="dropdown">
                            <option>Divisi IT</option>
                            <option>Divisi KEUANGAN</option>
                        </select>
                    </div>
                    <div class="card-content"
                        style="padding: 30px 20px; background: #f9f9f9; border-radius: 6px; margin: 10px 0;">
                        <div class="big-number">8</div>
                        <div class="label">Orang</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Pengajuan Peserta Magang</h2>
                    </div>
                    <div class="card-content"
                        style="padding: 30px 20px; background: #f9f9f9; border-radius: 6px; margin: 10px 0;">
                        <div class="big-number">10</div>
                        <div class="label">Peserta</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Data Absensi</h2>
                        <select class="dropdown">
                            <option>Semua</option>
                            <option>Hari Ini</option>
                            <option>Minggu Ini</option>
                        </select>
                    </div>
                    <div class="card-content">
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-number green">54</div>
                                <div class="stat-label">Hadir</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number red">6</div>
                                <div class="stat-label">Tidak Hadir</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
