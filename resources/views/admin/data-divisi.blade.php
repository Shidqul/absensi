<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>List Data Divisi</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
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
            margin-bottom: 5px;
            bottom: -5px;
            left: 0;
            right: 0;
            top: 0;
            /* jarak bawah sebelum tabel */
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
    </style>
</head>

<!-- Modal Edit Peserta -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-xl shadow-lg w-[750px] p-8 relative">
            <h2 class="text-2xl font-semibold mb-6">Edit Divisi</h2>

            <form id="editForm" class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
                <div>
                    <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="editNama" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" id="editUsername" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Asal Sekolah / Universitas</label>
                    <input type="text" id="editAsal" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Nama Pembimbing</label>
                    <input type="text" id="editPembimbing" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">No. Telp</label>
                    <input type="text" id="editTelp" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" id="editEmail" class="w-full border rounded-md px-3 py-2" />
                </div>
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1" for="editDurasi">Durasi Magang</label>
                    <input type="text" id="editDurasi" name="editDurasi" placeholder="Pilih tanggal"
                        class="w-full border rounded-md px-3 py-2" />
                </div>

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
        <main class="flex-1 p-8">
            <!-- Header: Judul & Tombol Export -->
            <h1 class="text-xl text-text-light dark:text-text-dark font-semibold mb-6">Data Divisi</h1>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="bg-indigo-900 text-white p-4">
                    <h2 class="text-xl font-semibold">List Divisi</h2>
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
                        <div class="relative inline-block text-left">
                            <a class="relative" href="#">
                                <select class="dropdown">
                                    <option value="semua">Semua</option>
                                    <option value="it">Divisi IT</option>
                                    <option value="keuangan">Divisi Keuangan</option>
                                </select>
                            </a>
                        </div>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Masukkan Nama"
                                aria-label="Search" />
                            <button class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">CARI</button>
                        </form>
                    </div>

                    <!-- Show Entries -->
                    <div class="flex items-center mb-6 text-sm text-gray-700 dark:text-gray-200">
                        <label class="mr-3" for="show-entries">Show</label>
                        <select
                            class="border rounded-md px-8 py-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            id="show-entries">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="ml-2">entries</span>
                    </div>

                    <div class="export-container">
                        <!-- Tombol tambah -->
                        <div class="export-container">
                            <button
                                class="add-button flex items-center gap-2 bg-[#4a58ad] text-white px-4 py-2 rounded-md hover:bg-[#3a4793] transition">
                                <i class="material-icons text-white text-base">add</i>
                                Tambah
                            </button>
                        </div>

                    </div>


                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkbox" id="checkAll"></th>
                                    <th>NO</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>DIVISI</th>
                                    <th>NO TELP</th>
                                    <th>NIP</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="checkbox row-checkbox"></td>
                                    <td>1</td>
                                    <td>Rudi Affandi, S.Kom., M.T.</td>
                                    <td>Teknologi & Informasi</td>
                                    <td>081274026680</td>
                                    <td>20004345322</td>
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
                                    <td>2</td>
                                    <td>Budi Sutanto, S.Kom., M.T.</td>
                                    <td>Teknologi & Informasi</td>
                                    <td>081944527644</td>
                                    <td>19904453363</td>
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
                                    <td>Prasetyo, S.E., M.M.</td>
                                    <td>Keuangan</td>
                                    <td>085733216577</td>
                                    <td>20062338764</td>
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

<!-- search, sort, show entries, dan divisi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("table tbody");
        const allRows = Array.from(tableBody.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const showSelect = document.getElementById("show-entries");
        const sortSelect = document.querySelector('select.w-48');
        const divisiSelect = document.querySelector(".dropdown");

        let filteredRows = [...allRows]; // hasil setelah filter
        let currentSort = "A-Z";

        // 🔹 Fungsi render ulang tabel
        function renderTable() {
            tableBody.innerHTML = "";

            // ambil nilai show entries (batas tampilan)
            const limit = showSelect ? parseInt(showSelect.value) : filteredRows.length;

            filteredRows.slice(0, limit).forEach((row, index) => {
                const clone = row.cloneNode(true);
                clone.querySelectorAll("td")[1].textContent = index + 1;
                tableBody.appendChild(clone);
            });
        }

        // 🔹 Fungsi filter divisi
        function filterDivisi(rows) {
            const selected = divisiSelect ? divisiSelect.value.toLowerCase() : "semua";
            return rows.filter(row => {
                const divisi = row.children[3].textContent.toLowerCase();
                if (selected === "semua") return true;
                if (selected === "divisi it" || selected === "it")
                    return divisi.includes("teknologi") || divisi.includes("informasi") || divisi
                        .includes("it");
                if (selected === "divisi keuangan" || selected === "keuangan")
                    return divisi.includes("keuangan");
                return true;
            });
        }

        // 🔹 Fungsi filter nama
        function filterNama(rows) {
            const keyword = searchInput ? searchInput.value.toLowerCase() : "";
            return rows.filter(row => row.children[2].textContent.toLowerCase().includes(keyword));
        }

        // 🔹 Fungsi urutkan
        function sortRows(rows) {
            return rows.sort((a, b) => {
                const nameA = a.children[2].textContent.toLowerCase();
                const nameB = b.children[2].textContent.toLowerCase();
                return currentSort === "A-Z" ?
                    nameA.localeCompare(nameB) :
                    nameB.localeCompare(nameA);
            });
        }

        // 🔹 Gabung semua filter
        function applyFilters() {
            let result = [...allRows];
            result = filterNama(result);
            result = filterDivisi(result);
            result = sortRows(result);
            filteredRows = result;
            renderTable();
        }

        // 🔹 Event listeners
        if (searchInput) searchInput.addEventListener("keyup", applyFilters);
        if (showSelect) showSelect.addEventListener("change", applyFilters);
        if (divisiSelect) divisiSelect.addEventListener("change", applyFilters);

        if (sortSelect) {
            sortSelect.innerHTML = `
            <option value="A-Z">A - Z</option>
            <option value="Z-A">Z - A</option>
        `;
            sortSelect.addEventListener("change", () => {
                currentSort = sortSelect.value;
                applyFilters();
            });
        }

        // 🔹 Render awal
        applyFilters();
    });
</script>


<!-- checkbox -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkAll = document.getElementById('checkAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');

        // ✅ Check/uncheck semua checkbox baris
        checkAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            checkAll.indeterminate = false; // reset state
        });

        // ✅ Update status checkAll saat checkbox individu berubah
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
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
    });
</script>




</html>
