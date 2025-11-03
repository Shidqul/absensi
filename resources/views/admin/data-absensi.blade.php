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

        /* Kontainer tombol di kolom AKSI */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            /* Jarak antar tombol */
        }

        /* Tombol umum di tabel */
        .action-buttons .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 12px;
            transition: all 0.2s ease;
            /* teks putih */
            color: #fff !important;

        }

        /* Ikon SVG agar sejajar dengan teks */
        .action-buttons .btn svg {
            margin-right: 6px;
            vertical-align: middle;
            /* ikon putih */
            fill: #fff;
        }

        /* Warna tombol Edit (hijau) */
        .action-buttons .btn-success {
            background-color: #4FD283;
            border-color: none;
        }

        .action-buttons .btn-success:hover {
            background-color: #4FD283;
            border-color: none;
        }

        /* Warna tombol Unduh (biru) */
        .action-buttons .btn-primary {
            background-color: #13A4EC;
            border-color: #13A4EC;
        }

        .action-buttons .btn-primary:hover {
            background-color: #13A4EC;
            border-color: #13A4EC;
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
                <!-- Username -->
                <div>
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" id="editUsername" class="w-full border rounded-md px-3 py-2" />
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
                <div class="bg-indigo-700 dark:bg-indigo-900 text-white p-4 rounded-t-lg">
                    <h3 class="font-semibold">List Data Absensi</h3>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-4">
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
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>TANGGAL</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>USERNAME</th>
                                    <th>JAM MASUK</th>
                                    <th>JAM PULANG</th>
                                    <th>KETERANGAN</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>15/04/2026</td>
                                    <td>Ade Setiawan</td>
                                    <td>adesetiawan113</td>
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
                                                Edit
                                            </button>

                                            <!-- Tombol Unduh -->
                                            <button type="button" class="btn btn-primary btn-unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5">
                                                    </path>
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z">
                                                    </path>
                                                </svg>
                                                Unduh
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>17/04/2026</td>
                                    <td>Satria Bima Nugroho</td>
                                    <td>satriabima127</td>
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
                                                Edit
                                            </button>

                                            <!-- Tombol Unduh -->
                                            <button type="button" class="btn btn-primary btn-unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5">
                                                    </path>
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z">
                                                    </path>
                                                </svg>
                                                Unduh
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>15/04/2026</td>
                                    <td>Candra Kusuma</td>
                                    <td>candrakusuma118</td>
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
                                                Edit
                                            </button>

                                            <!-- Tombol Unduh -->
                                            <button type="button" class="btn btn-primary btn-unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5">
                                                    </path>
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z">
                                                    </path>
                                                </svg>
                                                Unduh
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
                const firstCell = clone.querySelector("td:first-child");
                if (firstCell) firstCell.textContent = i + 1; // update nomor urut
                table.appendChild(clone);
            });
        }

        // 🔹 Filter berdasarkan nama (kolom ke-2)
        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const filtered = currentRows.filter(row => {
                const nameCell = row.children[2]; // kolom nama
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
                    "Jam Masuk": cells[4].textContent.trim(),
                    "Jam Pulang": cells[5].textContent.trim(),
                    "Keterangan": cells[6].textContent.trim(),

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
            ["Data Absensi Magang - AMPEL"]
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
        XLSX.utils.book_append_sheet(workbook, worksheet, "Data Absensi Magang");
        XLSX.writeFile(workbook, "Data_Data_Absensi_Magang.xlsx");
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
                <title>Data Absensi Magang</title>
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
                <h1>Data Absensi Magang</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>TANGGAL</th>
                            <th>NAMA LENGKAP</th>
                            <th>USERNAME</th>
                            <th>JAM MASUK</th>
                            <th>JAM PULANG</th>
                            <th>KETERANGAN</th>
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
                    <td>${peserta["Jam Masuk"]}</td>
                    <td>${peserta["Jam Pulang"]}</td>
                    <td>${peserta["Keterangan"]}</td>
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

<!-- Button Unduh  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pilih semua tombol unduh
        const unduhButtons = document.querySelectorAll("button.btn-unduh");

        unduhButtons.forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                if (!row) return;

                const cells = row.querySelectorAll("td");
                const data = {
                    no: cells[0]?.textContent.trim(),
                    tanggal: cells[1].textContent.trim(),
                    nama: cells[2].textContent.trim(),
                    username: cells[3].textContent.trim(),
                    masuk: cells[4].textContent.trim(),
                    pulang: cells[5].textContent.trim(),
                    keterangan: cells[6].textContent.trim(),
                };

                const printWindow = window.open('', '', 'height=700,width=800');
                printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Data Absensi Magang</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 40px; color: #333; }
                        h1 { text-align: center; color: #007BFF; margin-bottom: 30px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        td { padding: 10px; border: 1px solid #ccc; font-size: 13px; }
                        .label { background: #007BFF; color: #fff; width: 35%; font-weight: bold; }
                        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; }
                    </style>
                </head>
                <body>
                    <h1>Data Absensi Magang</h1>
                    <table>
                        <tr><td class="label">Tanggal</td><td>${data.tanggal}</td></tr>
                        <tr><td class="label">Nama Lengkap</td><td>${data.nama}</td></tr>
                        <tr><td class="label">Username</td><td>${data.username}</td></tr>
                        <tr><td class="label">Jam Masuk</td><td>${data.masuk}</td></tr>
                        <tr><td class="label">Jam Pulang</td><td>${data.pulang}</td></tr>
                        <tr><td class="label">Keterangan</td><td>${data.keterangan}</td></tr>
                        
                    </table>
                    <div class="footer">
                        Dicetak pada: ${new Date().toLocaleString('id-ID')} <br>
                        © AMPEL - Absensi Magang Polnes
                    </div>
                </body>
                </html>
            `);

                printWindow.document.close();
                printWindow.onload = function() {
                    printWindow.print();
                    setTimeout(() => printWindow.close(), 500);
                };
            });
        });
    });
</script>

<!-- Button Edit  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".btn-success");
        const modal = document.getElementById("editModal");
        const cancelBtn = document.getElementById("cancelEdit");
        const form = document.getElementById("editForm");

        // Event ketika klik tombol Edit
        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                const cells = row.querySelectorAll("td");

                // Isi form dari tabel
                document.getElementById("editTanggal").value = cells[1].textContent.trim();
                document.getElementById("editNama").value = cells[2].textContent.trim();
                document.getElementById("editUsername").value = cells[3].textContent.trim();
                document.getElementById("editMasuk").value = cells[4].textContent.trim();
                document.getElementById("editPulang").value = cells[5].textContent.trim();

                modal.classList.remove("hidden");
            });
        });

        // Tutup modal
        cancelBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            form.reset();
            preview.classList.add("hidden");
        });

        // Submit form (simulasi upload)
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            console.log("Data siap dikirim:");
            for (let pair of formData.entries()) {
                console.log(pair[0] + ':', pair[1]);
            }

            alert("Perubahan disimpan! (Simulasikan kirim data ke backend)");
            modal.classList.add("hidden");
            form.reset();
            preview.classList.add("hidden");
        });
    });

    flatpickr("#editTanggal", {
        mode: "range",
        dateFormat: "d-m-Y",
        defaultDate: ["02-05-2026"]
    });

    flatpickr("#editMasuk", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: "13:45"
    });

    flatpickr("#editPulang", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: "13:45"
    });
</script>

</html>
