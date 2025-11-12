<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pengajuan Izin</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4a58ad;
            /* biru */
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

        /* Warna tombol edit */
        .action-buttons .btn-success {
            background-color: #ffc107;
            /* warna kuning */
        }

        /* Warna tombol hapus */
        .action-buttons .btn-primary {
            background-color: #dc3545;
            /* warna merah */
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

        /* ✅ Perbaikan tampilan teks Deskripsi */
        #editDeskripsi {
            font-family: 'Inter', 'Roboto', sans-serif;
            line-height: 1.5;
            text-align: left;
            white-space: normal;
            /* teks normal, tidak preserve spasi berlebih */
            word-break: normal;
            overflow-wrap: break-word;
            /* cegah teks melebar */
            letter-spacing: 0.01em;
            /* spacing huruf konsisten */
        }

        #editDeskripsi:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        /* blur dan inisiasi */
        #editModal {
            backdrop-filter: blur(3px);
        }

        #editModal .rounded-xl {
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
            <h2 class="text-2xl font-semibold mb-6">Edit Laporan Pengajuan Izin</h2>

            <form id="editForm" class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
                <!-- Tanggal -->
                <div>
                    <label class="block text-gray-700 mb-1">Tanggal</label>
                    <input type="text" id="editTanggal" class="w-full border rounded-md px-3 py-2"
                        placeholder="Pilih tanggal..." />
                </div>
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="editNama" class="w-full border rounded-md px-3 py-2" />
                </div>
                <!-- Subjek -->
                <div>
                    <label class="block text-gray-700 mb-1">Subjek</label>
                    <input type="text" id="editSubjek" class="w-full border rounded-md px-3 py-2" />
                </div>
                <!-- DEskripsi -->
                <div>
                    <label class="block text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="editDeskripsi" name="deskripsi" rows="5"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200 resize-none" placeholder="Masukkan deskripsi..."></textarea>
                </div>
                <!-- Tombol Aksi -->
                <div class="col-span-2 flex justify-end mt-6">
                    <button type="button" id="cancelEdit" class="bg-gray-300 px-4 py-2 rounded-md mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark">
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
                        <a class="flex items-center p-2 rounded-md hover:bg-white/20 transition-colors" href="/laporan">
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
            <h1 class="text-xl text-text-light dark:text-text-dark font-semibold mb-6">Pengajuan Izin</h1>
            <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow">
                <div class="bg-indigo-900 text-white p-4">
                    <h2 class="text-xl font-semibold">Laporan Pengajuan Izin</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <a class="relative">
                                <select id="laporanSelect"
                                    class="w-48 appearance-none bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-md py-2 pl-3 pr-10 text-text-light dark:text-text-dark focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    <option value="dataabsensi">Data Absensi</option>
                                    <option value="pengajuanizin">Pengajuan Izin</option>
                                </select>
                            </a>
                            <!-- Filter & Search -->
                            <input type="text" id="filterDate" placeholder="Pilih rentang tanggal..." readonly>
                            <i class="fas fa-filter mb-4" id="filterIcon" style="color: #666; cursor: pointer;"></i>
                            <form class="flex" role="search">
                                <input class="border border-gray-300 rounded-md py-2 px-3 mr-2" type="search"
                                    placeholder="Masukkan Nama" aria-label="Search" />
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">CARI</button>
                            </form>
                        </div>
                    </div>

                    <!-- Baris Baru untuk Show Entries dan Export Data -->
                    <div class="flex items-center justify-between mb-4">
                        <!-- Show Entries -->
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-600">Show </span>
                            <select id="entriesSelect"
                                class="w-20 border border-gray-300 rounded-md py-2 pl-3 pr-8 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="ml-2">Entries</span>
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
                                    <th>No.</th>
                                    <th>TANGGAL</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>SUBJEK</th>
                                    <th class="text-center">DESKRIPSI</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>1.</td>
                                    <td>26 april 2026</td>
                                    <td>Ade Setiawan</td>
                                    <td>Izin Cuti Mengurus SIM A</td>
                                    <td class="description-cell">
                                        Selamat pagi, Saya Ade Setiawan, mahasiswa Universitas Tunggal Jaya, Divisi IT,
                                        mengajukan izin pada hari ini dikarena...
                                    </td>
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

                                            <!-- Tombol discard -->
                                            <button type="button" class="btn btn-primary">
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
                                    <td>27 april 2026</td>
                                    <td>Bagus Putra Irwanto</td>
                                    <td>Izin Cuti Kakek Meninggal</td>
                                    <td class="description-cell">
                                        Selamat pagi,Saya Bagus Putra Irwanto, mahasiswa Universitas Pelita, Divisi IT,
                                        mengajukan izin pada hari ini dikarena...
                                    </td>
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

                                            <!-- Tombol discard -->
                                            <button type="button" class="btn btn-primary">
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
                                    <td>29 april 2026</td>
                                    <td>Friska Dewi Gerania</td>
                                    <td>Izin Cuti Sakit</td>
                                    <td class="description-cell">
                                        Selamat pagi,Saya Friska Dewi Gerania, mahasiswa Universitas Mawar, Divisi
                                        Keuangan,mengajukan izin pada hari ini dikarena...
                                    </td>
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

                                            <!-- Tombol discard -->
                                            <button type="button" class="btn btn-primary">
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

<!-- Dropdown pindah halaman -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const laporanSelect = document.getElementById("laporanSelect");
        const currentPath = window.location.pathname;

        if (laporanSelect) {
            laporanSelect.addEventListener("change", function() {
                const selectedValue = this.value;
                if (selectedValue) {
                    window.location.href = selectedValue;
                }
            });

            // Set selected option berdasarkan current path
            for (const option of laporanSelect.options) {
                if (currentPath.includes(option.value.replace('/', ''))) {
                    option.selected = true;
                    break;
                }
            }
        }
    });
</script>

<!-- Filter Search -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const showSelect = document.getElementById("show-entries");

        // Simpan reference ke semua rows asli
        window.allTableRows = [...rows];
        window.currentFilteredRows = [...rows]; // Rows setelah filter tanggal

        // 🔹 Render tabel ulang
        function renderTable(data) {
            table.innerHTML = "";
            if (data.length === 0) {
                const noDataRow = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = rows[0].children.length;
                td.textContent = "Tidak ada data ditemukan";
                td.classList.add("text-center", "text-gray-500");
                noDataRow.appendChild(td);
                table.appendChild(noDataRow);
                return;
            }

            data.forEach((row, i) => {
                const clone = row.cloneNode(true);

                // Update nomor urut di kolom ke-2
                const numberCell = clone.querySelector("td:nth-child(2)");
                if (numberCell) {
                    numberCell.textContent = (i + 1) + ".";
                }

                table.appendChild(clone);
            });
        }

        // 🔹 Filter berdasarkan nama (kolom ke-4)
        function filterTable() {
            const keyword = searchInput.value.toLowerCase();

            // Filter dari currentFilteredRows (hasil filter tanggal)
            const filtered = window.currentFilteredRows.filter(row => {
                const nameCell = row.children[3]; // kolom nama (index ke-3)
                if (!nameCell) return false;
                return nameCell.textContent.toLowerCase().includes(keyword);
            });

            const limit = showSelect ? parseInt(showSelect.value) : filtered.length;
            renderTable(filtered.slice(0, limit));
        }

        // 🔹 Expose fungsi untuk digunakan filter tanggal
        window.applySearchFilter = filterTable;

        // 🔹 Event listener
        if (showSelect) showSelect.addEventListener("change", filterTable);
        if (searchInput) searchInput.addEventListener("keyup", filterTable);

        // 🔹 Render awal
        const initialLimit = showSelect ? parseInt(showSelect.value) : window.currentFilteredRows.length;
        renderTable(window.currentFilteredRows.slice(0, initialLimit));
    });
</script>

<!-- Filter Tanggal dengan Flatpickr Range -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById('filterDate');
        const filterIcon = document.getElementById('filterIcon');

        // Daftar nama bulan dalam bahasa Indonesia
        const bulanIndo = [
            "januari", "februari", "maret", "april", "mei", "juni",
            "juli", "agustus", "september", "oktober", "november", "desember"
        ];

        // 🔹 Inisialisasi Flatpickr dengan mode RANGE
        const flatpickrInstance = flatpickr(dateInput, {
            mode: "range",
            dateFormat: "Y-m-d",
            allowInput: false,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                        'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ]
                },
                rangeSeparator: ' sampai '
            },
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    filterByDateRange(selectedDates);
                } else if (selectedDates.length === 0) {
                    // Reset filter tanggal
                    resetDateFilter();
                }
            }
        });

        // 🔹 Fungsi konversi string tanggal tabel ke Date object
        function parseTableDate(dateString) {
            const parts = dateString.toLowerCase().trim().split(' ');

            if (parts.length !== 3) return null;

            const day = parseInt(parts[0]);
            const monthIndex = bulanIndo.indexOf(parts[1]);
            const year = parseInt(parts[2]);

            if (monthIndex === -1 || isNaN(day) || isNaN(year)) return null;

            return new Date(year, monthIndex, day);
        }

        // 🔹 Fungsi utama filter rentang tanggal
        function filterByDateRange(selectedDates) {
            const startDate = new Date(selectedDates[0]);
            const endDate = new Date(selectedDates[1]);

            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(23, 59, 59, 999);

            // Filter dari allTableRows (semua data asli)
            const filteredRows = window.allTableRows.filter(row => {
                const tanggalCell = row.cells[2].textContent.trim();
                const rowDate = parseTableDate(tanggalCell);

                if (!rowDate) return false;

                return rowDate >= startDate && rowDate <= endDate;
            });

            // Update currentFilteredRows untuk filter search
            window.currentFilteredRows = filteredRows;

            // Terapkan juga filter search yang sedang aktif
            if (window.applySearchFilter) {
                window.applySearchFilter();
            }

            if (filteredRows.length === 0) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const startStr = startDate.toLocaleDateString('id-ID', options);
                const endStr = endDate.toLocaleDateString('id-ID', options);
                alert(`Tidak ada data dari ${startStr} sampai ${endStr}`);
            }
        }

        // 🔹 Reset filter tanggal
        function resetDateFilter() {
            window.currentFilteredRows = [...window.allTableRows];
            if (window.applySearchFilter) {
                window.applySearchFilter();
            }
        }

        // 🔹 Event Listener untuk icon filter
        filterIcon.addEventListener('click', () => {
            flatpickrInstance.open();
            filterIcon.style.transform = 'scale(1.2)';
            setTimeout(() => filterIcon.style.transform = 'scale(1)', 200);
        });
    });
</script>


<!-- Export Data  -->
<script>
    // Toggle Export Dropdown
    const exportBtn = document.getElementById('exportBtn');
    const exportDropdown = document.getElementById('exportDropdown');

    if (exportBtn && exportDropdown) {
        exportBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            exportDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            exportDropdown.classList.remove('show');
        });
    }

    // Ambil data dari tabel HTML
    function getTableData() {
        const rows = document.querySelectorAll("tbody tr");
        const data = [];
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll("td");
            if (cells.length >= 7) {
                data.push({
                    "No": index + 1,
                    "Tanggal": cells[1].textContent.trim(),
                    "Nama Lengkap": cells[2].textContent.trim(),
                    "Username": cells[3].textContent.trim(),
                    "Subjek": cells[4].textContent.trim(),
                    "Deskripsi": cells[5].textContent.trim(),
                    "Waktu kirim": cells[6].textContent.trim(),
                    "Status": cells[7].textContent.trim(),
                });
            }
        });
        return data;
    }

    // ✅ Export ke Excel (versi rapi)
    function exportToExcel() {
        const data = getTableData();
        if (data.length === 0) {
            alert("Tidak ada data untuk diexport!");
            return;
        }

        // Buat worksheet dan workbook
        const worksheet = XLSX.utils.json_to_sheet(data, {
            origin: "A2"
        });
        const workbook = XLSX.utils.book_new();

        // Tambah judul laporan di atas tabel
        XLSX.utils.sheet_add_aoa(worksheet, [
            ["Laporan Izin - AMPEL"]
        ], {
            origin: "A1"
        });

        // Format header tabel (bold)
        const header = Object.keys(data[0]);
        XLSX.utils.sheet_add_aoa(worksheet, [header], {
            origin: "A2"
        });

        // ✅ Auto width kolom
        const columnWidths = header.map(h => {
            const maxLength = Math.max(
                h.length,
                ...data.map(d => d[h]?.toString().length || 0)
            );
            return {
                wch: maxLength + 3
            }; // tambah padding
        });
        worksheet['!cols'] = columnWidths;

        // Tambah border (manual styling basic)
        const range = XLSX.utils.decode_range(worksheet['!ref']);
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const cellRef = XLSX.utils.encode_cell({
                    r: R,
                    c: C
                });
                if (!worksheet[cellRef]) continue;
                worksheet[cellRef].s = {
                    border: {
                        top: {
                            style: "thin",
                            color: {
                                rgb: "000000"
                            }
                        },
                        bottom: {
                            style: "thin",
                            color: {
                                rgb: "000000"
                            }
                        },
                        left: {
                            style: "thin",
                            color: {
                                rgb: "000000"
                            }
                        },
                        right: {
                            style: "thin",
                            color: {
                                rgb: "000000"
                            }
                        },
                    },
                    alignment: {
                        vertical: "center",
                        horizontal: "left",
                        wrapText: true
                    },
                };
                if (R === 1) { // header row
                    worksheet[cellRef].s.font = {
                        bold: true
                    };
                    worksheet[cellRef].s.fill = {
                        fgColor: {
                            rgb: "DCE6F1"
                        }
                    };
                }
            }
        }

        // Tambah worksheet ke workbook dan simpan file
        XLSX.utils.book_append_sheet(workbook, worksheet, "Laporan Izin");
        XLSX.writeFile(workbook, "Data_Laporan_Izin.xlsx");
    }

    // Export ke PDF (Perbaikan utama)
    function exportToPDF() {
        const data = getTableData();
        if (data.length === 0) {
            alert("Tidak ada data untuk diexport!");
            return;
        }

        const printWindow = window.open('', '', 'height=600,width=800');

        let htmlContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Laporan Izin</title>
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
                        margin-bottom: 5px;
                    }
                    .subtitle {
                        color: #666;
                        font-size: 14px;
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
                    <div class="subtitle">Absensi Magang Polnes</div>
                </div>
                <h1>Laporan Izin</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>TANGGAL</th>
                            <th>NAMA LENGKAP</th>
                            <th>USERNAME</th>
                            <th>SUBJEK</th>
                            <th>DESKRIPSI</th>
                            <th>WAKTU KIRIM</th>
                            <th>STATUS</th>
                            
                        </tr>
                    </thead>
                    <tbody>
        `;

        // ✅ Perbaikan mapping kolom agar sesuai dengan data
        data.forEach(peserta => {
            htmlContent += `
                <tr>
                    <td>${peserta["No"]}</td>
                    <td>${peserta["Tanggal"]}</td>
                    <td>${peserta["Nama Lengkap"]}</td>
                    <td>${peserta["Username"]}</td>
                    <td>${peserta["Subjek"]}</td>
                    <td>${peserta["Deskripsi"]}</td>
                    <td>${peserta["Waktu kirim"]}</td>
                    <td>${peserta["Status"]}</td>
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
            setTimeout(() => {
                printWindow.close();
            }, 300);
        };

        exportDropdown.classList.remove('show');
    }
</script>


<!-- Button Edit -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("editModal");
        const cancelBtn = document.getElementById("cancelEdit");
        const form = document.getElementById("editForm");
        const tableBody = document.querySelector("#dataTable tbody");
        let currentRow = null;

        // ✅ Inisialisasi Flatpickr tanpa mode range (single date)
        const flatpickrInstance = flatpickr("#editTanggal", {
            dateFormat: "d F Y",
            allowInput: true,
            clickOpens: true,
            locale: {
                firstDayOfWeek: 1,
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
            onReady: function(_, __, instance) {
                instance.input.placeholder = "Pilih tanggal absensi";
            }
        });

        // ✅ Event delegation untuk tombol Edit dengan class btn-success
        tableBody.addEventListener("click", function(e) {
            // Cari tombol dengan class btn-success (bisa klik button atau icon di dalamnya)
            const button = e.target.closest(".btn-success");
            if (!button) return;

            currentRow = button.closest("tr");

            // Ambil data dari kolom tabel
            const tanggal = currentRow.querySelector("td:nth-child(3)")?.textContent.trim() || "";
            const nama = currentRow.querySelector("td:nth-child(4)")?.textContent.trim() || "";
            const subjek = currentRow.querySelector("td:nth-child(5)")?.textContent.trim() || "";

            // Ambil deskripsi dan bersihkan whitespace berlebih
            const deskripsiCell = currentRow.querySelector("td:nth-child(6)");
            let deskripsi = deskripsiCell?.innerText || deskripsiCell?.textContent || "";

            // Metode pembersihan SUPER AGRESIF
            deskripsi = deskripsi
                .split(/\s+/) // Split by any whitespace
                .filter(word => word) // Remove empty strings
                .join(' '); // Join with single space

            // Isi nilai ke form modal
            document.getElementById("editNama").value = nama;
            document.getElementById("editSubjek").value = subjek;
            document.getElementById("editDeskripsi").value = deskripsi;

            // ✅ Set nilai Flatpickr untuk single date
            if (tanggal) {
                // Parse tanggal Indonesia ke Date object
                function parseIndonesianDate(dateStr) {
                    const months = {
                        'januari': 0,
                        'februari': 1,
                        'maret': 2,
                        'april': 3,
                        'mei': 4,
                        'juni': 5,
                        'juli': 6,
                        'agustus': 7,
                        'september': 8,
                        'oktober': 9,
                        'november': 10,
                        'desember': 11
                    };

                    // Format: "27 april 2026"
                    const parts = dateStr.toLowerCase().split(' ');
                    if (parts.length === 3) {
                        const day = parseInt(parts[0]);
                        const month = months[parts[1]];
                        const year = parseInt(parts[2]);
                        if (month !== undefined) {
                            return new Date(year, month, day);
                        }
                    }
                    return null;
                }

                const singleDate = parseIndonesianDate(tanggal);
                if (singleDate) {
                    flatpickrInstance.setDate(singleDate, true);
                }
            } else {
                flatpickrInstance.clear();
            }

            modal.classList.remove("hidden");
        });

        // Tombol batal
        cancelBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            form.reset();
            flatpickrInstance.clear();
            currentRow = null;
        });

        // Submit form - Update data di tabel
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            if (currentRow) {
                // ✅ Ambil nilai tanggal dari Flatpickr instance
                const tanggalValue = flatpickrInstance.input.value.trim();

                // Update data di tabel
                if (tanggalValue) {
                    currentRow.querySelector("td:nth-child(3)").textContent = tanggalValue;
                }
                currentRow.querySelector("td:nth-child(4)").textContent = document.getElementById(
                    "editNama").value.trim();
                currentRow.querySelector("td:nth-child(5)").textContent = document.getElementById(
                    "editSubjek").value.trim();
                currentRow.querySelector("td:nth-child(6)").textContent = document.getElementById(
                    "editDeskripsi").value.trim();

                // Log data untuk debugging (simulasi kirim ke backend)
                const formData = new FormData(form);
                console.log("Data siap dikirim:");
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ':', pair[1]);
                }

                alert("Perubahan disimpan! (Data berhasil diperbarui)");
            }

            modal.classList.add("hidden");
            form.reset();
            flatpickrInstance.clear();
            currentRow = null;
        });
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

<!-- Button Delete  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("#dataTable tbody");

        // Fungsi untuk update nomor urut
        function updateRowNumbers() {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach((row, index) => {
                const numberCell = row.querySelector(
                    "td:nth-child(2)"); // Kolom No (index 2 karena ada checkbox di index 1)
                if (numberCell) {
                    numberCell.textContent = (index + 1) + ".";
                }
            });
        }

        // Fungsi untuk update status checkbox "Select All"
        function updateCheckAllStatus() {
            const checkAll = document.querySelector("#checkAll");
            const rowCheckboxes = document.querySelectorAll(".row-checkbox");
            const checkedBoxes = document.querySelectorAll(".row-checkbox:checked");

            if (checkAll && rowCheckboxes.length > 0) {
                checkAll.checked = checkedBoxes.length === rowCheckboxes.length;
            }
        }

        // Expose fungsi ke window agar bisa dipanggil dari script lain
        window.updateRowNumbers = updateRowNumbers;
        window.updateCheckAllStatus = updateCheckAllStatus;

        // Event Delegation: Delete Button
        tableBody.addEventListener("click", function(e) {
            const target = e.target.closest("button");
            if (!target) return;

            // Tombol Hapus (btn-primary dengan icon trash)
            if (target.classList.contains("btn-primary")) {
                const row = target.closest("tr");

                if (confirm("Yakin ingin menghapus data ini?")) {
                    row.remove();

                    // Update nomor urut setelah hapus
                    updateRowNumbers();

                    // Update status checkbox "Select All"
                    updateCheckAllStatus();

                    // Cek apakah tabel kosong
                    const remainingRows = tableBody.querySelectorAll("tr");
                    if (remainingRows.length === 0) {
                        // Optional: Tambahkan pesan jika tabel kosong
                        const emptyRow = document.createElement("tr");
                        emptyRow.innerHTML = `
                            <td colspan="8" style="text-align: center; padding: 20px; color: #666;">
                                Tidak ada data absensi
                            </td>
                        `;
                        tableBody.appendChild(emptyRow);
                    }
                }
            }
        });

        // Optional: Tambahkan event listener untuk checkbox "Select All"
        const checkAll = document.querySelector("#checkAll");
        if (checkAll) {
            checkAll.addEventListener("change", function() {
                const rowCheckboxes = document.querySelectorAll(".row-checkbox");
                rowCheckboxes.forEach(cb => cb.checked = checkAll.checked);
            });
        }

        // Optional: Update status "Select All" saat individual checkbox diubah
        tableBody.addEventListener("change", function(e) {
            if (e.target.classList.contains("row-checkbox")) {
                updateCheckAllStatus();
            }
        });
    });
</script>

</html>
