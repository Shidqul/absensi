<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Absensi</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
        /* Styling untuk header "List Data Absensi" - sesuai dengan "List Peserta Magang" */
        .page-header,
        h1.page-title,
        .list-header {
            background-color: #3b3f8f;
            /* Biru navy seperti List Peserta Magang */
            color: #ffffff;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px 8px 0 0;
        }

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
            font-size: 15px;
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
            <h2 class="text-2xl font-semibold mb-6">Edit Laporan Magang</h2>

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
                <!-- Jam Masuk -->
                <div>
                    <label class="block text-gray-700 mb-1">Jam Masuk</label>
                    <input type="text" id="editMasuk" class="w-full border rounded-md px-3 py-2"
                        placeholder="Pilih Jam Masuk..." />
                </div>
                <!-- Jam Pulang -->
                <div>
                    <label class="block text-gray-700 mb-1">Jam Pulang</label>
                    <input type="text" id="editPulang" class="w-full border rounded-md px-3 py-2"
                        placeholder="Pilih Jam Pulang..." />
                </div>
                <!-- Keterangan -->
                <div>
                    <label class="block text-gray-700 mb-1">Keterangan</label>
                    <select id="editKeterangan"
                        class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Ketrangan</option>
                        <option value="TEPAT WAKTU">TEPAT WAKTU</option>
                        <option value="TELAT">TELAT</option>
                    </select>
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
        <main class="flex-1 p-8 overflow-y-auto">
            <!-- Header: Judul & Tombol Export -->
            <header class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Absensi</h2>
            </header>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="bg-indigo-700 dark:bg-indigo-900 text-white p-4 rounded-t-lg"
                    style="background-color: #3b3f8f;">
                    <h3 class="font-semibold">List Data Absensi</h3>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- dropdown pindah halaman  -->
                            <a class="relative">
                                <select id="laporanSelect"
                                    class="w-48 appearance-none bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-md py-2 pl-3 pr-10 text-text-light dark:text-text-dark focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    <option value="dataabsensi">Data Absensi</option>
                                    <option value="pengajuanizin">Pengajuan Izin</option>
                                </select>
                            </a>
                            <!-- Filter & Search -->
                            <input type="date" value="2026-04-26">
                            <i class="fas fa-filter mb-4" style="color: #666; cursor: pointer;"></i>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Masukkan Nama"
                                    aria-label="Search" />
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">CARI</button>
                            </form>
                        </div>
                    </div>
                    <!-- Show Entries -->
                    <div class="flex items-center mb-4">
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

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="dataTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkbox" id="checkAll"></th>
                                    <th>No.</th>
                                    <th>TANGGAL</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>JAM MASUK</th>
                                    <th>JAM PULANG</th>
                                    <th>KETERANGAN</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>1.</td>
                                    <td>15 april 2026</td>
                                    <td>Ade Setiawan</td>
                                    <td>07:34:22</td>
                                    <td>17:06:15</td>
                                    <td><span class="status-badge status-tepat">TEPAT WAKTU</span></td>
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
                                    <td>17 april 2026</td>
                                    <td>Satria Bima Nugroho</td>
                                    <td>07:42:22</td>
                                    <td>17:11:15</td>
                                    <td><span class="status-badge status-tepat">TEPAT WAKTU</span></td>
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
                                    <td>15 april 2026</td>
                                    <td>Candra Kusuma</td>
                                    <td>08:02:22</td>
                                    <td>17:07:15</td>
                                    <td><span class="status-badge status-terlambat">TELAT</span></td>
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

<!-- Filter Search -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const showSelect = document.getElementById("show-entries");

        let currentRows = [...rows];

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

                // Update nomor urut di kolom ke-2 (bukan kolom pertama yang berisi checkbox)
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
            const filtered = currentRows.filter(row => {
                const nameCell = row.children[3]; // kolom nama (index ke-3)
                if (!nameCell) return false;
                return nameCell.textContent.toLowerCase().includes(keyword);
            });

            const limit = showSelect ? parseInt(showSelect.value) : filtered.length;
            renderTable(filtered.slice(0, limit));
        }

        // 🔹 Event listener
        if (showSelect) showSelect.addEventListener("change", filterTable);
        if (searchInput) searchInput.addEventListener("keyup", filterTable);

        // 🔹 Render awal
        const initialLimit = showSelect ? parseInt(showSelect.value) : currentRows.length;
        renderTable(currentRows.slice(0, initialLimit));
    });
</script>

<!-- Filter Tanggal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.querySelector('input[type="date"]');
        const filterIcon = document.querySelector('.fa-filter');
        const tableBody = document.querySelector("table tbody");
        const allRows = Array.from(tableBody.querySelectorAll("tr"));

        // 🔹 Fungsi Filter Berdasarkan Tanggal
        function filterByDate() {
            const selectedDate = dateInput.value;

            if (!selectedDate) {
                // Jika tanggal kosong, tampilkan semua data
                renderFilteredRows(allRows);
                return;
            }

            // Konversi format tanggal untuk perbandingan
            const [year, month, day] = selectedDate.split('-');
            const formattedDate = `${day}/${month}/${year}`;

            // Filter baris berdasarkan tanggal
            const filteredRows = allRows.filter(row => {
                const tanggalCell = row.cells[1].textContent.trim(); // Kolom TANGGAL
                return tanggalCell === formattedDate;
            });

            renderFilteredRows(filteredRows);

            // Tampilkan alert jika tidak ada data
            if (filteredRows.length === 0) {
                alert('Tidak ada data untuk tanggal: ' + formattedDate);
            }
        }

        // 🔹 Fungsi Render Hasil Filter
        function renderFilteredRows(rows) {
            tableBody.innerHTML = '';

            if (rows.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            Tidak ada data yang ditemukan
                        </td>
                    </tr>
                `;
                return;
            }

            // Batasi sesuai dengan Show Entries
            const entriesSelect = document.getElementById('entriesSelect');
            const limit = entriesSelect ? parseInt(entriesSelect.value) : 10;

            rows.slice(0, limit).forEach(row => {
                tableBody.appendChild(row.cloneNode(true));
            });
        }

        // 🔹 Event: Saat tanggal berubah
        dateInput.addEventListener('change', filterByDate);

        // 🔹 Event: Saat ikon filter diklik
        filterIcon.addEventListener('click', function() {
            filterByDate();

            // Animasi klik pada ikon
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });

        // 🔹 Reset Filter (tombol tambahan - opsional)
        // Jika ingin tambahkan tombol reset, gunakan kode ini:

        const resetBtn = document.getElementById('resetFilter');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                dateInput.value = '';
                renderFilteredRows(allRows);
            });
        }

    });
</script>

<!-- Export Data Absensi Berdasarkan Checkbox -->
<script>
    // ===============================
    // 🔹 Toggle Dropdown Export
    // ===============================
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

    // ===============================
    // 🔹 Checkbox "Select All" (Header)
    // ===============================
    const checkAll = document.querySelector('#checkAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = checkAll.checked);
        });
    }

    // ===============================
    // 🔹 Ambil Data dari Baris yang Dicentang
    // ===============================
    function getCheckedRowsData() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const data = [];

        checkedBoxes.forEach((checkbox, index) => {
            const row = checkbox.closest('tr');
            const cells = row.querySelectorAll('td');

            // Sesuaikan dengan struktur tabel absensi
            data.push({
                "No": index + 1,
                "Tanggal": cells[2]?.textContent.trim() || "",
                "Nama Lengkap": cells[3]?.textContent.trim() || "",
                "Jam Masuk": cells[4]?.textContent.trim() || "",
                "Jam Pulang": cells[5]?.textContent.trim() || "",
                "Keterangan": cells[6]?.textContent.trim() || "",
            });
        });

        return data;
    }

    // ===============================
    // 🔹 Export ke Excel
    // ===============================
    function exportToExcel() {
        const data = getCheckedRowsData();

        if (data.length === 0) {
            alert("Silakan pilih minimal satu data dengan mencentang checkbox!");
            return;
        }

        const workbook = XLSX.utils.book_new();

        const title = [
            ["Data Absensi Magang - AMPEL"]
        ];
        const worksheet = XLSX.utils.json_to_sheet(data, {
            origin: "A3"
        });

        XLSX.utils.sheet_add_aoa(worksheet, title, {
            origin: "A1"
        });

        // Tambahkan header style bold
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
                },
                fill: {
                    fgColor: {
                        rgb: "DCE6F1"
                    }
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

        // Tambahkan border ke semua cell
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const cellRef = XLSX.utils.encode_cell({
                    r: R,
                    c: C
                });
                if (!worksheet[cellRef]) continue;
                if (!worksheet[cellRef].s) worksheet[cellRef].s = {};
                worksheet[cellRef].s.border = {
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
                };
                if (!worksheet[cellRef].s.alignment) {
                    worksheet[cellRef].s.alignment = {
                        vertical: "center",
                        horizontal: "left",
                        wrapText: true
                    };
                }
            }
        }

        // Tambahkan tanggal cetak
        const footerRow = data.length + 5;
        XLSX.utils.sheet_add_aoa(
            worksheet,
            [
                ["Dicetak pada:", new Date().toLocaleString('id-ID')]
            ], {
                origin: `A${footerRow}`
            }
        );

        XLSX.utils.book_append_sheet(workbook, worksheet, "Data Absensi Magang");
        XLSX.writeFile(workbook, "Data_Absensi_Magang.xlsx");
    }

    // ===============================
    // 🔹 Export ke PDF
    // ===============================
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
            <title>Data Absensi Magang</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .logo { font-size: 28px; font-weight: bold; color: #039BE5; margin-bottom: 5px; }
                .subtitle { color: #666; font-size: 14px; }
                h1 { text-align: center; color: #1A202C; margin: 20px 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
                th { background-color: #039BE5; color: white; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="logo">AMPEL</div>
                <div class="subtitle">Absensi Magang Pelindo</div>
            </div>
            <h1>Data Absensi Magang</h1>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>TANGGAL</th>
                        <th>NAMA LENGKAP</th>
                        <th>JAM MASUK</th>
                        <th>JAM PULANG</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>`;

        data.forEach(peserta => {
            htmlContent += `
                <tr>
                    <td>${peserta["No"]}</td>
                    <td>${peserta["Tanggal"]}</td>
                    <td>${peserta["Nama Lengkap"]}</td>
                    <td>${peserta["Jam Masuk"]}</td>
                    <td>${peserta["Jam Pulang"]}</td>
                    <td>${peserta["Keterangan"]}</td>
                </tr>`;
        });

        htmlContent += `
                </tbody>
            </table>
            <div class="footer">
                Dicetak pada: ${new Date().toLocaleString('id-ID')}
            </div>
        </body>
        </html>`;

        printWindow.document.write(htmlContent);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
            setTimeout(() => printWindow.close(), 300);
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
        const keteranganSelect = document.getElementById("editKeterangan");
        let currentRow = null;

        // ✅ Inisialisasi Flatpickr
        const tanggalPicker = flatpickr("#editTanggal", {
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

        const jamMasukPicker = flatpickr("#editMasuk", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true
        });

        const jamPulangPicker = flatpickr("#editPulang", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true
        });

        // ✅ Event delegation untuk tombol Edit
        tableBody.addEventListener("click", function(e) {
            const button = e.target.closest(".btn-success");
            if (!button) return;

            currentRow = button.closest("tr");

            // Ambil data dari kolom tabel
            const tanggal = currentRow.querySelector("td:nth-child(3)")?.textContent.trim() || "";
            const nama = currentRow.querySelector("td:nth-child(4)")?.textContent.trim() || "";
            const jamMasuk = currentRow.querySelector("td:nth-child(5)")?.textContent.trim() || "";
            const jamPulang = currentRow.querySelector("td:nth-child(6)")?.textContent.trim() || "";
            const keterangan = currentRow.querySelector("td:nth-child(7)")?.textContent.trim() || "";

            // Isi form
            document.getElementById("editNama").value = nama;
            document.getElementById("editMasuk").value = jamMasuk;
            document.getElementById("editPulang").value = jamPulang;
            document.getElementById("editKeterangan").value = keterangan;

            // ✅ Set tanggal ke Flatpickr
            if (tanggal) {
                function parseIndoDate(dateStr) {
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
                        if (!isNaN(day) && !isNaN(month) && !isNaN(year)) {
                            return new Date(year, month, day);
                        }
                    }
                    return null;
                }
                const dateObj = parseIndoDate(tanggal);
                if (dateObj) tanggalPicker.setDate(dateObj, true);
            } else {
                tanggalPicker.clear();
            }

            modal.classList.remove("hidden");
        });

        // ✅ Tombol Batal
        cancelBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            form.reset();
            tanggalPicker.clear();
            currentRow = null;
        });

        // ✅ Submit form untuk update data tabel
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            if (currentRow) {
                const tanggalValue = tanggalPicker.input.value.trim();
                const namaValue = document.getElementById("editNama").value.trim();
                const masukValue = document.getElementById("editMasuk").value.trim();
                const pulangValue = document.getElementById("editPulang").value.trim();
                const ketValue = document.getElementById("editKeterangan").value.trim();

                // Update tabel
                if (tanggalValue) currentRow.querySelector("td:nth-child(3)").textContent =
                    tanggalValue;
                currentRow.querySelector("td:nth-child(4)").textContent = namaValue;
                currentRow.querySelector("td:nth-child(5)").textContent = masukValue;
                currentRow.querySelector("td:nth-child(6)").textContent = pulangValue;
                currentRow.querySelector("td:nth-child(7)").textContent = ketValue;

                // Log untuk debug
                const formData = new FormData(form);
                console.log("Data diperbarui:");
                for (let [key, val] of formData.entries()) {
                    console.log(`${key}: ${val}`);
                }

                alert("Perubahan disimpan! (Data berhasil diperbarui)");
            }

            modal.classList.add("hidden");
            form.reset();
            tanggalPicker.clear();
            currentRow = null;
        });
    });
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

</html>
