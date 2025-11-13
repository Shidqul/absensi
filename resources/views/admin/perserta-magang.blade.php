<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>List Peserta Magang</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        /* Bungkus tombol Export Data dalam container agar bisa diatur posisinya */
        .export-container {
            display: flex;
            justify-content: flex-end;
            /* posisi ke kanan */
            align-items: center;
            margin-bottom: 10px;
            /* jarak bawah sebelum tabel */
        }

        /* Tombol Export Data */
        .export-btn {
            background-color: #13A4EC;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .export-btn:hover {
            background-color: #0f8ed3;
        }

        /* 🔹 Dropdown Export Data */
        .export-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 5px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
            display: none;
            z-index: 100;
        }

        .export-dropdown.show {
            display: block;
        }

        .export-option {
            padding: 10px 15px;
            font-size: 13px;
            cursor: pointer;
            color: #333;
            display: flex;
            align-items: center;
        }

        .export-option:hover {
            background: #f3f4f6;
        }


        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #00b4d8;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        tr:hover {
            background: #f9f9f9;
        }

        /* ✅ Tampilkan checkbox dengan gaya default */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
            /* warna biru */
            cursor: pointer;
        }

        /* Kontainer tombol di kolom AKSI */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            /* Jarak antar tombol */
        }

        /* ✅ Ukuran tombol aksi seragam */
        .action-buttons .btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: 0.2s;
            color: #fff;
            padding: 0;
            /* hilangkan padding agar ukuran fix */
        }

        /* Warna tombol approval */
        .action-buttons .btn-secondary {
            background-color: #4FD283;
            /* warna hijau */
        }


        /* Warna tombol reject */
        .action-buttons .btn-warning {
            background-color: #D24F4F;
            /* warna merah */
        }


        /* Warna tombol edit */
        .action-buttons .btn-success {
            background-color: #ffc107;
            /* warna kuning */
        }

        /* Warna tombol preview */
        .action-buttons .btn-info {
            background-color: #4FBAD2;
            /* warna blue */
        }

        /* Warna tombol hapus */
        .action-buttons .btn-primary {
            background-color: #dc3545;
            /* warna merah */
        }

        .d-none {
            display: none !important;
        }

        /* Responsive - jaga jarak tombol di layar kecil */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 6px;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }

        .flatpickr-calendar {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }

        .flatpickr-day {
            color: #4a5568;
        }

        .flatpickr-day.selected {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .flatpickr-day:hover {
            background: #dbeafe;
        }

        .flatpickr-months .flatpickr-month {
            color: #111827;
        }

        .flatpickr-current-month .numInputWrapper {
            color: #111827;
        }

        .flatpickr-weekdays {
            color: #111827;
        }

        /* ✅ Hilangkan jarak di input flatpickr */
        #editDurasi.flatpickr-input {
            width: 100% !important;
        }

        /* ✅ Sembunyikan input alternatif jika ada */
        .flatpickr-input.flatpickr-mobile {
            display: none !important;
        }

        /* Sembunyikan kolom Username (ke-9) dan Cv (ke-10) */
        .hide-col {
            display: none;
        }

        /* blur dan inisiasi */
        #editModal {
            backdrop-filter: blur(3px);
        }

        #editModal .rounded-xl {
            animation: scaleIn 0.25s ease;
        }

        #approvalModal {
            backdrop-filter: blur(3px);
        }

        #approvalModal .rounded-xl {
            animation: scaleIn 0.25s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<!-- Modal Edit Peserta -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-xl shadow-lg w-[750px] p-8 relative">
            <h2 class="text-2xl font-semibold mb-6">Edit Peserta Magang</h2>

            <form id="editForm" class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
                <!-- NAMA LENGKAP -->
                <div>
                    <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="editNama" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Asal Sekolah / Universitas -->
                <div>
                    <label class="block text-gray-700 mb-1">Asal Sekolah / Universitas</label>
                    <input type="text" id="editAsal" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- No. Telp -->
                <div>
                    <label class="block text-gray-700 mb-1">No. Telp</label>
                    <input type="text" id="editTelp" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Durasi Magang -->
                <div>
                    <label class="block text-gray-700 mb-1" for="editDurasi">Durasi Magang</label>
                    <input type="text" id="editDurasi" name="durasi" class="border rounded px-3 py-2 w-full"
                        placeholder="Pilih tanggal">
                </div>

                <!-- Divisi -->
                <div>
                    <label class="block text-gray-700 mb-1">Divisi</label>
                    <input type="text" id="editDivisi" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Nama Pembimbing -->
                <div>
                    <label class="block text-gray-700 mb-1">Nama Pembimbing</label>
                    <input type="text" id="editPembimbing" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" id="editUsername" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Curriculum Vitae (CV) -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Curriculum Vitae (CV)</label>
                    <div class="flex items-center gap-3">
                        <input type="file" id="editCv" accept=".pdf"
                            class="border rounded-md px-3 py-2 w-full" />
                        <a id="cvPreviewLink" href="#" target="_blank"
                            class="text-blue-600 underline hidden">Lihat CV</a>
                    </div>
                    <small class="text-gray-500 text-sm block mt-1">Format: PDF (max 2MB)</small>
                </div>

                <!-- Tombol -->
                <div class="col-span-2 flex justify-end mt-6">
                    <button type="button" id="cancelEdit" class="bg-gray-300 px-4 py-2 rounded-md mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Modal Approval -->
<div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-xl shadow-lg w-[600px] p-8 relative">
            <h2 class="text-2xl font-semibold mb-6 text-center">Approve Peserta Magang</h2>

            <p class="text-gray-600 text-center mb-6">Lengkapi form di bawah ini.</p>

            <form id="approvalForm" class="grid grid-cols-2 gap-4">
                <!-- Username -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" id="approvalUsername"
                        class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        placeholder="Tambah username" required />
                </div>

                <!-- Divisi -->
                <div>
                    <label class="block text-gray-700 mb-1">Divisi</label>
                    <select id="approvalDivisi"
                        class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Divisi</option>
                        <option value="Teknologi & Informasi">Teknologi & Informasi</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="HRD">HRD</option>
                    </select>
                </div>

                <!-- Pembimbing Lapangan -->
                <div>
                    <label class="block text-gray-700 mb-1">Pembimbing Lapangan</label>
                    <select id="approvalPembimbing"
                        class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Pembimbing</option>
                        <option value="Rudi Affandi, S.Kom., M.T.">Rudi Affandi, S.Kom., M.T.</option>
                        <option value="Prasetyo, S.E., M.M.">Prasetyo, S.E., M.M.</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-span-2 flex justify-end mt-6">
                    <button type="button" id="cancelApproval"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mr-2 transition">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>


<body class="bg-background-light dark:bg-background-dark font-display">
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
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/datadivisi">
                            <span class="material-icons mr-3">badge</span>
                            DATA DiVISI
                        </a>
                    </li>
                    <!-- Laporan -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/laporan">
                            <span class="material-icons mr-3">description</span>
                            LAPORAN
                        </a>
                    </li>
                    <!-- Absensi -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors"
                            href="/dataabsensi">
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
            <!-- Header: Judul & Tombol Export -->
            <h1 class="text-xl text-text-light dark:text-text-dark font-semibold mb-6">Peserta Magang</h1>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="bg-indigo-900 text-white p-4">
                    <h2 class="text-xl font-semibold">List Peserta Magang</h2>
                </div>
                <!-- Filter & Search -->
                <div class="p-6">
                    <div class="flex items-center mb-4 space-x-4">
                        <div class="relative inline-block text-left">
                            <a class="relative" href="#">
                                <select
                                    class="w-48 appearance-none bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-md py-2 pl-5 pr-10 fs-7 text-text-light dark:text-text-dark focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    <option>Urutkan Sesuai Abjad</option>
                                </select>
                            </a>
                        </div>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Masukkan Nama"
                                aria-label="Search" />
                            <button class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">CARI</button>
                        </form>
                    </div>

                    <!-- Container untuk Show Entries dan Export Data -->
                    <div class="flex items-center justify-between mb-4">
                        <!-- Show Entries -->
                        <div class="flex items-center">
                            <span class="mr-2 text-gray-700 dark:text-gray-300">Show</span>
                            <select id="showEntries"
                                class="border rounded-md px-8 py-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">entries</span>
                        </div>

                        <!-- Export Data -->
                        <div class="export-container">
                            <div style="position: relative;">
                                <button id="exportBtn"
                                    class="bg-indigo-900 text-white px-5 py-2 rounded-md hover:bg-indigo-800 flex items-center space-x-2">
                                    <span class="material-icons text-sm">download</span>
                                    <span>Export Data</span>
                                    <span class="material-icons text-sm">expand_more</span>
                                </button>
                                <div class="export-dropdown" id="exportDropdown">
                                    <div class="export-option" onclick="exportToExcel()">
                                        <span class="material-icons text-sm align-middle mr-2">table_chart</span>
                                        Export Data ke Excel
                                    </div>
                                    <div class="export-option" onclick="exportToPDF()">
                                        <span class="material-icons text-sm align-middle mr-2">picture_as_pdf</span>
                                        Export Data ke PDF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="dataTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkbox" id="checkAll"></th>
                                    <th>NO.</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>ASAL SEKOLAH/UNIVERSITAS</th>
                                    <th>NO TELP</th>
                                    <th>DURASI MAGANG</th>
                                    <th>DIVISI</th>
                                    <th>NAMA PEMBIMBING LAPANGAN</th>
                                    <th class="hide-col">Username</th>
                                    <th class="hide-col">Cv</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>1</td>
                                    <td>Ade Setiawan</td>
                                    <td>Universitas Tunggal Jaya</td>
                                    <td>081244025567</td>
                                    <td>18 Juni 2026 -
                                        18 September 2026</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td class="hide-col">ade123</td>
                                    <td class="hide-col"><a href="">Lihat CV</a></td>
                                    <td>
                                        <div class="action-buttons d-flex gap-2">
                                            <!-- Tombol approval -->
                                            <button type="button" class="btn btn-secondary btn-approval">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="m5 13l4 4L19 7" />
                                                </svg>
                                            </button>

                                            <!-- Tombol reject -->
                                            <button type="button" class="btn btn-warning btn-reject">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="M6.758 17.243L12.001 12m5.243-5.243L12 12m0 0L6.758 6.757M12.001 12l5.243 5.243" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-hidden d-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Tombol Eyes -->
                                            <button type="button" class="btn btn-info btn-hidden d-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                        d="M12 17.8c4.034 0 7.686-2.25 9.648-5.8C19.686 8.45 16.034 6.2 12 6.2S4.314 8.45 2.352 12c1.962 3.55 5.614 5.8 9.648 5.8M12 5c4.808 0 8.972 2.848 11 7c-2.028 4.152-6.192 7-11 7s-8.972-2.848-11-7c2.028-4.152 6.192-7 11-7m0 9.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Discard -->
                                            <button type="button"
                                                class="btn btn-primary btn-hidden btn-unduh d-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="M14 11v6m-4-6v6M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M4 7h16M7 7l2-4h6l2 4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>2</td>
                                    <td>Bobby Mahendra</td>
                                    <td>Universitas Makmur</td>
                                    <td>081944527644</td>
                                    <td>18 Juni 2026 -
                                        18 September 2026</td>
                                    <td>Teknologi & Informasi</td>
                                    <td>Rudi Affandi, S.Kom., M.T.</td>
                                    <td class="hide-col">boby123</td>
                                    <td class="hide-col"><a href="">Lihat CV</a></td>
                                    <td>
                                        <div class="action-buttons d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Tombol Eyes -->
                                            <button type="button" class="btn btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                        d="M12 17.8c4.034 0 7.686-2.25 9.648-5.8C19.686 8.45 16.034 6.2 12 6.2S4.314 8.45 2.352 12c1.962 3.55 5.614 5.8 9.648 5.8M12 5c4.808 0 8.972 2.848 11 7c-2.028 4.152-6.192 7-11 7s-8.972-2.848-11-7c2.028-4.152 6.192-7 11-7m0 9.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Discard -->
                                            <button type="button" class="btn btn-primary btn-unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="M14 11v6m-4-6v6M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M4 7h16M7 7l2-4h6l2 4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>3</td>
                                    <td>Deni Saputra</td>
                                    <td>Universitas Kampiun</td>
                                    <td>085733216577</td>
                                    <td>12 April 2026 -
                                        12 Juli 2026</td>
                                    <td>Keuangan</td>
                                    <td>Prasetyo, S.E., M.M.</td>
                                    <td class="hide-col">deni123</td>
                                    <td class="hide-col"><a href="">Lihat CV</a></td>
                                    <td>
                                        <div class="action-buttons d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Tombol Eyes -->
                                            <button type="button" class="btn btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                        d="M12 17.8c4.034 0 7.686-2.25 9.648-5.8C19.686 8.45 16.034 6.2 12 6.2S4.314 8.45 2.352 12c1.962 3.55 5.614 5.8 9.648 5.8M12 5c4.808 0 8.972 2.848 11 7c-2.028 4.152-6.192 7-11 7s-8.972-2.848-11-7c2.028-4.152 6.192-7 11-7m0 9.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Discard -->
                                            <button type="button" class="btn btn-primary btn-unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="M14 11v6m-4-6v6M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M4 7h16M7 7l2-4h6l2 4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    updateClock();
</script>

<!-- Filter  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const showSelect = document.getElementById("show-entries");
        const sortSelect = document.querySelector('select.w-48'); // dropdown "Urutkan Sesuai"

        let currentRows = [...rows]; // data asli tabel

        // 🔹 Fungsi render ulang tabel
        function renderTable(data) {
            table.innerHTML = "";
            data.forEach((row, i) => {
                const clone = row.cloneNode(true);
                // Kolom nomor urut ada di kolom ke-2 (setelah checkbox)
                clone.querySelectorAll("td")[1].textContent = i + 1;
                table.appendChild(clone);
            });
        }

        // 🔹 Fungsi pencarian nama
        function filterTable() {
            const keyword = searchInput ? searchInput.value.toLowerCase() : "";
            const filtered = currentRows.filter(row =>
                row.children[2].textContent.toLowerCase().includes(keyword)
            );
            renderTable(filtered.slice(0, showSelect ? showSelect.value : filtered.length));
        }

        // 🔹 Isi opsi urutan lengkap
        if (sortSelect) {
            sortSelect.innerHTML = `
            <option value="name-asc">Nama (A - Z)</option>
            <option value="name-desc">Nama (Z - A)</option>
            <option value="school-asc">Asal Sekolah (A - Z)</option>
            <option value="school-desc">Asal Sekolah (Z - A)</option>
        `;
        }

        // 🔹 Fungsi urutkan tabel
        if (sortSelect) {
            sortSelect.addEventListener("change", () => {
                const selected = sortSelect.value;
                let sorted = [...rows];

                if (selected === "name-asc") {
                    sorted.sort((a, b) =>
                        a.children[2].textContent.localeCompare(b.children[2].textContent)
                    );
                } else if (selected === "name-desc") {
                    sorted.sort((a, b) =>
                        b.children[2].textContent.localeCompare(a.children[2].textContent)
                    );
                } else if (selected === "school-asc") {
                    sorted.sort((a, b) =>
                        a.children[3].textContent.localeCompare(b.children[3].textContent)
                    );
                } else if (selected === "school-desc") {
                    sorted.sort((a, b) =>
                        b.children[3].textContent.localeCompare(a.children[3].textContent)
                    );
                }

                currentRows = sorted;
                filterTable();
            });
        }

        // 🔹 Fungsi ubah jumlah tampilan (show entries)
        if (showSelect) {
            showSelect.addEventListener("change", filterTable);
        }

        // 🔹 Fungsi pencarian realtime
        if (searchInput) {
            searchInput.addEventListener("keyup", filterTable);
        }

        // 🔹 Render awal tabel
        renderTable(currentRows.slice(0, showSelect ? showSelect.value : currentRows.length));
    });
</script>


<!-- checkbox -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkAll = document.getElementById('checkAll');
        const table = document.querySelector('table');

        if (!checkAll || !table) return;

        // 🔹 Fungsi ambil ulang semua checkbox baris yang ada saat ini
        function getRowCheckboxes() {
            return table.querySelectorAll('.row-checkbox');
        }

        // 🔹 Saat checkbox utama di header diubah
        checkAll.addEventListener('change', function() {
            const rowCheckboxes = getRowCheckboxes();
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            checkAll.indeterminate = false;
        });

        // 🔹 Delegasi event untuk mendeteksi perubahan di checkbox baris
        table.addEventListener('change', function(e) {
            if (!e.target.classList.contains('row-checkbox')) return;

            const rowCheckboxes = getRowCheckboxes();
            const total = rowCheckboxes.length;
            const checked = Array.from(rowCheckboxes).filter(c => c.checked).length;

            if (checked === 0) {
                checkAll.checked = false;
                checkAll.indeterminate = false;
            } else if (checked === total) {
                checkAll.checked = true;
                checkAll.indeterminate = false;
            } else {
                checkAll.checked = false;
                checkAll.indeterminate = true;
            }
        });
    });
</script>


<!-- Export data berdasarkan checkbox -->
<script>
    // Toggle Export Dropdown
    const exportBtn = document.getElementById('exportBtn');
    const exportDropdown = document.getElementById('exportDropdown');

    if (exportBtn && exportDropdown) {
        exportBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            exportDropdown.classList.toggle('show');
        });

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function() {
            exportDropdown.classList.remove('show');
        });
    }

    // 🔹 Ambil data dari baris yang dicentang
    function getCheckedRowsData() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const data = [];
        checkedBoxes.forEach((checkbox, index) => {
            const row = checkbox.closest('tr');
            const cells = row.querySelectorAll('td');
            if (cells.length >= 8) {
                data.push({
                    "NO.": index + 1,
                    "NAMA LENGKAP": cells[2].textContent.trim(),
                    "ASAL SEKOLAH/UNIVERSITAS": cells[3].textContent.trim(),
                    "NO TELP": cells[4].textContent.trim(),
                    "DURASI MAGANG": cells[5].textContent.trim(),
                    "DIVISI": cells[6].textContent.trim(),
                    "NAMA PEMBIMBING LAPANGAN": cells[7].textContent.trim(),
                });
            }
        });
        return data;
    }

    // ✅ Export ke Excel (berdasarkan checkbox)
    function exportToExcel() {
        const data = getCheckedRowsData();
        if (data.length === 0) {
            alert("Silakan pilih minimal satu data dengan mencentang checkbox!");
            return;
        }

        const workbook = XLSX.utils.book_new();

        // Tambahkan judul laporan di baris pertama
        const title = [
            ["Laporan Data Peserta Magang - AMPEL"]
        ];
        const worksheet = XLSX.utils.json_to_sheet(data, {
            origin: "A3"
        });
        XLSX.utils.sheet_add_aoa(worksheet, title, {
            origin: "A1"
        });

        // Tambahkan header style (bold)
        const range = XLSX.utils.decode_range(worksheet['!ref']);
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cellAddress = XLSX.utils.encode_cell({
                r: 2,
                c: C
            });
            if (!worksheet[cellAddress]) continue;
            worksheet[cellAddress].s = {
                font: {
                    bold: true
                }
            };
        }

        // Lebar kolom otomatis
        const header = Object.keys(data[0]);
        worksheet['!cols'] = header.map(h => ({
            wch: Math.max(
                h.length + 2,
                ...data.map(d => (d[h] ? d[h].toString().length : 0))
            ) + 2
        }));

        // Tambahkan tanggal cetak di bawah tabel
        const footerRow = data.length + 5;
        XLSX.utils.sheet_add_aoa(
            worksheet,
            [
                ["Dicetak pada:", new Date().toLocaleString('id-ID')]
            ], {
                origin: `A${footerRow}`
            }
        );

        // Simpan workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Peserta Magang");
        XLSX.writeFile(workbook, "Data_Peserta_Magang.xlsx");
    }

    // ✅ Export ke PDF (berdasarkan checkbox)
    function exportToPDF() {
        const data = getCheckedRowsData();
        if (data.length === 0) {
            alert("Silakan pilih minimal satu data dengan mencentang checkbox!");
            return;
        }

        const printWindow = window.open('', '', 'height=600,width=800');

        let htmlContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Data Peserta Magang</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    .logo {
                        font-size: 28px;
                        font-weight: bold;
                        color: #039BE5;
                    }
                    h1 {
                        text-align: center;
                        color: #1A202C;
                        margin: 20px 0;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                        font-size: 12px;
                    }
                    th {
                        background-color: #039BE5;
                        color: white;
                    }
                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo">AMPEL</div>
                    <div class="subtitle">Absensi Magang Pelindo</div>
                </div>
                <h1>Data Peserta Magang</h1>
                <table>
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>NAMA LENGKAP</th>
                            <th>ASAL SEKOLAH/UNIVERSITAS</th>
                            <th>NO TELP</th>
                            <th>DURASI MAGANG</th>
                            <th>DIVISI</th>
                            <th>NAMA PEMBIMBING LAPANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.forEach(item => {
            htmlContent += `
                <tr>
                    <td>${item["NO."]}</td>
                    <td>${item["NAMA LENGKAP"]}</td>
                    <td>${item["ASAL SEKOLAH/UNIVERSITAS"]}</td>
                    <td>${item["NO TELP"]}</td>
                    <td>${item["DURASI MAGANG"]}</td>
                    <td>${item["DIVISI"]}</td>
                    <td>${item["NAMA PEMBIMBING LAPANGAN"]}</td>
                </tr>
            `;
        });

        htmlContent += `
                    </tbody>
                </table>
                <div class="footer">
                    Dicetak pada: ${new Date().toLocaleString('id-ID')}
                </div>
            </body>
            </html>
        `;

        printWindow.document.write(htmlContent);
        printWindow.document.close();

        printWindow.onload = function() {
            printWindow.print();
            setTimeout(() => printWindow.close(), 300);
        };

        exportDropdown.classList.remove('show');
    }
</script>


<!-- Button edit -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("editModal");
        const cancelBtn = document.getElementById("cancelEdit");
        const form = document.getElementById("editForm");
        const cvInput = document.getElementById("editCv");
        const cvLink = document.getElementById("cvPreviewLink");
        const tableBody = document.querySelector("#dataTable tbody");
        let currentRow = null;

        // ✅ Inisialisasi Flatpickr LANGSUNG di sini
        const flatpickrInstance = flatpickr("#editDurasi", {
            mode: "range",
            dateFormat: "d F Y",
            allowInput: true,
            clickOpens: true,
            locale: {
                firstDayOfWeek: 1,
                rangeSeparator: ' - ',
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                        'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ]
                }
            },
            onReady: function(selectedDates, dateStr, instance) {
                instance.input.placeholder = "18 Juni 2026 - 18 September 2026";
            }
        });

        // Event delegation untuk tombol Edit
        tableBody.addEventListener("click", function(e) {
            const button = e.target.closest(".btn-success");
            if (!button) return;

            currentRow = button.closest("tr");

            // Ambil data dari kolom tabel
            const nama = currentRow.querySelector("td:nth-child(3)")?.textContent.trim() || "";
            const asal = currentRow.querySelector("td:nth-child(4)")?.textContent.trim() || "";
            const telp = currentRow.querySelector("td:nth-child(5)")?.textContent.trim() || "";
            const durasi = currentRow.querySelector("td:nth-child(6)")?.textContent.trim() || "";
            const divisi = currentRow.querySelector("td:nth-child(7)")?.textContent.trim() || "";
            const pembimbing = currentRow.querySelector("td:nth-child(8)")?.textContent.trim() || "";
            const username = currentRow.querySelector("td.hide-col.username")?.textContent.trim() || "";
            const cvCell = currentRow.querySelector("td.hide-col.cv");

            // Isi nilai ke form modal
            document.getElementById("editNama").value = nama;
            document.getElementById("editAsal").value = asal;
            document.getElementById("editTelp").value = telp;
            document.getElementById("editDivisi").value = divisi;
            document.getElementById("editPembimbing").value = pembimbing;
            document.getElementById("editUsername").value = username;

            // ✅ Set nilai Flatpickr dengan format yang benar
            if (durasi && durasi.includes(' - ')) {
                const dates = durasi.split(' - ').map(d => d.trim());

                // Parse tanggal Indonesia ke Date object
                function parseIndonesianDate(dateStr) {
                    const months = {
                        'Januari': 0,
                        'Februari': 1,
                        'Maret': 2,
                        'April': 3,
                        'Mei': 4,
                        'Juni': 5,
                        'Juli': 6,
                        'Agustus': 7,
                        'September': 8,
                        'Oktober': 9,
                        'November': 10,
                        'Desember': 11
                    };

                    const parts = dateStr.split(' ');
                    if (parts.length === 3) {
                        const day = parseInt(parts[0]);
                        const month = months[parts[1]];
                        const year = parseInt(parts[2]);
                        return new Date(year, month, day);
                    }
                    return null;
                }

                const startDate = parseIndonesianDate(dates[0]);
                const endDate = parseIndonesianDate(dates[1]);

                if (startDate && endDate) {
                    flatpickrInstance.setDate([startDate, endDate], true);
                }
            } else if (durasi) {
                // Jika durasi tunggal (bukan range)
                function parseIndonesianDate(dateStr) {
                    const months = {
                        'Januari': 0,
                        'Februari': 1,
                        'Maret': 2,
                        'April': 3,
                        'Mei': 4,
                        'Juni': 5,
                        'Juli': 6,
                        'Agustus': 7,
                        'September': 8,
                        'Oktober': 9,
                        'November': 10,
                        'Desember': 11
                    };

                    const parts = dateStr.split(' ');
                    if (parts.length === 3) {
                        const day = parseInt(parts[0]);
                        const month = months[parts[1].charAt(0).toUpperCase() + parts[1].slice(1)
                            .toLowerCase()];
                        const year = parseInt(parts[2]);
                        if (month !== undefined) {
                            return new Date(year, month, day);
                        }
                    }
                    return null;
                }

                const singleDate = parseIndonesianDate(durasi);
                if (singleDate) {
                    flatpickrInstance.setDate(singleDate, true);
                }
            } else {
                flatpickrInstance.clear();
            }

            // Tampilkan link CV lama jika ada
            if (cvCell && cvCell.querySelector("a")) {
                const cvUrl = cvCell.querySelector("a").getAttribute("href");
                cvLink.href = cvUrl;
                cvLink.textContent = "Lihat CV Lama";
                cvLink.classList.remove("hidden");
            } else {
                cvLink.classList.add("hidden");
            }

            modal.classList.remove("hidden");
        });

        // Tombol batal
        cancelBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            form.reset();
            flatpickrInstance.clear();
            cvLink.classList.add("hidden");
            currentRow = null;
        });

        // Preview CV baru (PDF)
        cvInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file && file.type === "application/pdf") {
                const fileURL = URL.createObjectURL(file);
                cvLink.href = fileURL;
                cvLink.textContent = "Pratinjau CV Baru";
                cvLink.classList.remove("hidden");
            } else {
                cvLink.classList.add("hidden");
            }
        });

        // Submit form - Update data di tabel
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            if (currentRow) {
                // ✅ Ambil nilai durasi dari Flatpickr instance, bukan dari input langsung
                const durasiValue = flatpickrInstance.input.value.trim();

                // Update data di tabel
                currentRow.querySelector("td:nth-child(3)").textContent = document.getElementById(
                    "editNama").value.trim();
                currentRow.querySelector("td:nth-child(4)").textContent = document.getElementById(
                    "editAsal").value.trim();
                currentRow.querySelector("td:nth-child(5)").textContent = document.getElementById(
                    "editTelp").value.trim();
                if (durasiValue) {
                    currentRow.querySelector("td:nth-child(6)").textContent = durasiValue;
                }
                currentRow.querySelector("td:nth-child(7)").textContent = document.getElementById(
                    "editDivisi").value.trim();
                currentRow.querySelector("td:nth-child(8)").textContent = document.getElementById(
                    "editPembimbing").value.trim();

                // Log data untuk debugging (simulasi kirim ke backend)
                const formData = new FormData(form);
                console.log("Data siap dikirim:");
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ':', pair[1]);
                }

                alert("Data berhasil diperbarui!");
            }

            modal.classList.add("hidden");
            form.reset();
            flatpickrInstance.clear();
            cvLink.classList.add("hidden");
            currentRow = null;
        });
    });
</script>



<!-- Button Hidden  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const approvalButtons = document.querySelectorAll('.btn-approval');
        const rejectButtons = document.querySelectorAll('.btn-reject');

        const modal = document.getElementById('approvalModal');
        const cancelBtn = document.getElementById('cancelApproval');
        const approvalForm = document.getElementById('approvalForm');

        const usernameInput = document.getElementById('approvalUsername');
        const divisiSelect = document.getElementById('approvalDivisi');
        const pembimbingSelect = document.getElementById('approvalPembimbing');

        let selectedRow = null; // simpan baris yang sedang di-approve

        // === [1] Klik tombol approval → buka modal ===
        approvalButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                selectedRow = this.closest('tr');
                modal.classList.remove('hidden'); // tampilkan modal
            });
        });

        // === [2] Klik batal → tutup modal ===
        cancelBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            approvalForm.reset();
            selectedRow = null;
        });

        // === [3] Submit form approval ===
        approvalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedRow) return;

            const username = usernameInput.value.trim();
            const divisi = divisiSelect.value;
            const pembimbing = pembimbingSelect.value;

            if (!username || !divisi || !pembimbing) {
                alert("Lengkapi semua field sebelum menyetujui peserta.");
                return;
            }

            // Update tabel sesuai input form
            selectedRow.querySelector('td:nth-child(7)').textContent = divisi;
            selectedRow.querySelector('td:nth-child(8)').textContent = pembimbing;
            selectedRow.querySelector('td:nth-child(9)').textContent = username;

            // Sembunyikan tombol approval & reject
            const actionContainer = selectedRow.querySelector('.action-buttons');
            const approveBtn = actionContainer.querySelector('.btn-approval');
            const rejectBtn = actionContainer.querySelector('.btn-reject');
            if (approveBtn) approveBtn.classList.add('d-none');
            if (rejectBtn) rejectBtn.classList.add('d-none');

            // Tampilkan tombol yang tersembunyi
            const hiddenButtons = actionContainer.querySelectorAll('.btn-hidden');
            hiddenButtons.forEach(b => b.classList.remove('d-none'));

            // Tutup modal
            modal.classList.add('hidden');
            approvalForm.reset();
            selectedRow = null;
        });

        // === [4] Tombol reject ===
        rejectButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menolak pendaftar ini?')) {
                    const row = this.closest('tr');
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        updateRowNumbers();
                    }, 300);
                }
            });
        });

        // === [5] Fungsi update nomor urut ===
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#dataTable tbody tr');
            rows.forEach((row, index) => {
                const noCell = row.querySelector('td:nth-child(2)');
                if (noCell) noCell.textContent = index + 1;
            });
        }
    });
</script>


<!-- Button Delete  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("#dataTable tbody");
        const checkAll = document.querySelector("#checkAll");

        // Fungsi untuk update nomor urut
        function updateRowNumbers() {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach((row, index) => {
                // Update nomor di kolom kedua (td:nth-child(2))
                const noCell = row.querySelector("td:nth-child(2)");
                if (noCell) {
                    noCell.textContent = index + 1;
                }
            });
        }

        // Fungsi untuk update status checkbox "Check All"
        function updateCheckAllStatus() {
            if (!checkAll) return;

            const allCheckboxes = tableBody.querySelectorAll('.row-checkbox');
            const checkedCheckboxes = tableBody.querySelectorAll('.row-checkbox:checked');

            if (allCheckboxes.length === 0) {
                checkAll.checked = false;
                checkAll.indeterminate = false;
            } else if (checkedCheckboxes.length === allCheckboxes.length) {
                checkAll.checked = true;
                checkAll.indeterminate = false;
            } else if (checkedCheckboxes.length > 0) {
                checkAll.checked = false;
                checkAll.indeterminate = true;
            } else {
                checkAll.checked = false;
                checkAll.indeterminate = false;
            }
        }

        // Expose fungsi ke window
        window.updateRowNumbers = updateRowNumbers;
        window.updateCheckAllStatus = updateCheckAllStatus;

        // Event Delegation: Delete Button (btn-unduh dengan icon trash)
        tableBody.addEventListener("click", function(e) {
            const target = e.target.closest("button");
            if (!target) return;

            // Tombol Delete (btn-unduh dengan icon trash)
            if (target.classList.contains("btn-unduh")) {
                const row = target.closest("tr");

                if (confirm("Yakin ingin menghapus data ini?")) {
                    // Tambahkan animasi fade out (opsional)
                    row.style.transition = "opacity 0.3s";
                    row.style.opacity = "0";

                    setTimeout(() => {
                        row.remove();
                        updateRowNumbers();
                        updateCheckAllStatus();
                    }, 300);
                }
            }
        });

        // Check All functionality
        if (checkAll) {
            checkAll.addEventListener("change", function() {
                const allCheckboxes = tableBody.querySelectorAll('.row-checkbox');
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
            });
        }

        // Individual checkbox change
        tableBody.addEventListener("change", function(e) {
            if (e.target.classList.contains("row-checkbox")) {
                updateCheckAllStatus();
            }
        });

        // Initialize check all status
        updateCheckAllStatus();
    });
</script>


</html>
