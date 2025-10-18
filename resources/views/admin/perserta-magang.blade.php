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
    </style>
</head>

<!-- Modal Edit Peserta -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-xl shadow-lg w-[750px] p-8 relative">
            <h2 class="text-2xl font-semibold mb-6">Edit Peserta Magang</h2>

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
                    <label class="block text-gray-700 mb-1">Durasi Magang</label>
                    <input type="text" id="editDurasi" class="w-full border rounded-md px-3 py-2" />
                </div>

                <!-- Bagian CV -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Curriculum Vitae (CV)</label>
                    <div class="flex items-center gap-3">
                        <input type="file" id="editCv" accept=".pdf"
                            class="border rounded-md px-3 py-2 w-full" />
                        <a id="cvPreviewLink" href="#" target="_blank"
                            class="text-blue-600 underline hidden">Lihat
                            CV</a>
                    </div>
                    <small class="text-gray-500 text-sm block mt-1">Format: PDF (max 2MB)</small>
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
                        <!-- Tombol Export -->
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
                                    <th>NO</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>USERNAME</th>
                                    <th>NAMA PEMBIMBING</th>
                                    <th>ASAL SEKOLAH/UNIVERSITAS</th>
                                    <th>NO TELP</th>
                                    <th>EMAIL</th>
                                    <th>DURASI MAGANG</th>
                                    <th>CV</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ade Setiawan</td>
                                    <td>adestwn13</td>
                                    <td>Budi Sutanto, S.Kom., M.T.</td>
                                    <td>Universitas Tunggal Jaya</td>
                                    <td>081244025567</td>
                                    <td>adesetiawan54@gmail.com</td>
                                    <td>10-07-2026 - 10-09-2026</td>
                                    <td>CV-Ade Setiawan.pdf</td>
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
                                    <td>Bobby Mahendra</td>
                                    <td>bobbymhndr122</td>
                                    <td>Rudi Affandi, S.I., M.T.</td>
                                    <td>Universitas Makmur</td>
                                    <td>081944527644</td>
                                    <td>bobbymh23@gmail.com</td>
                                    <td>15-07-2026 - 15-09-2026</td>
                                    <td>CV-Bobby Mahendra.pdf</td>
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
                                    <td>Deni Saputra</td>
                                    <td>denisptr119</td>
                                    <td>Prasetyo, S.I., M.T.</td>
                                    <td>Universitas Kampiun</td>
                                    <td>085733216577</td>
                                    <td>denissptr30@gmail.com</td>
                                    <td>12-07-2026 - 12-09-2026</td>
                                    <td>CV-Deni Saputra.pdf</td>
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

<!-- Filter  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const showSelect = document.getElementById("show-entries");
        const sortSelect = document.querySelector('select.w-48'); // select untuk urutkan

        let currentRows = [...rows]; // simpan data awal

        // 🔹 Fungsi render ulang tabel
        function renderTable(data) {
            table.innerHTML = "";
            data.forEach((row, i) => {
                const clone = row.cloneNode(true);
                clone.querySelector("td:first-child").textContent = i + 1; // update nomor urut
                table.appendChild(clone);
            });
        }

        // 🔹 Fungsi cari nama
        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const filtered = currentRows.filter(row =>
                row.children[1].textContent.toLowerCase().includes(keyword)
            );
            renderTable(filtered.slice(0, showSelect.value));
        }

        // 🔹 Fungsi urutkan abjad
        sortSelect.addEventListener("change", () => {
            const selected = sortSelect.value;
            let sorted = [...currentRows];
            if (selected === "A-Z") {
                sorted.sort((a, b) =>
                    a.children[1].textContent.localeCompare(b.children[1].textContent)
                );
            } else if (selected === "Z-A") {
                sorted.sort((a, b) =>
                    b.children[1].textContent.localeCompare(a.children[1].textContent)
                );
            }
            currentRows = sorted;
            filterTable();
        });

        // 🔹 Fungsi ubah jumlah tampilan (show entries)
        showSelect.addEventListener("change", filterTable);

        // 🔹 Fungsi pencarian realtime
        searchInput.addEventListener("keyup", filterTable);

        // 🔹 Isi opsi urutan (A-Z / Z-A)
        sortSelect.innerHTML = `
        <option value="A-Z">A - Z</option>
        <option value="Z-A">Z - A</option>
    `;

        // 🔹 Render awal
        renderTable(currentRows.slice(0, showSelect.value));
    });
</script>

<!-- Export data  -->
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
                    "Nama Lengkap": cells[1].textContent.trim(),
                    "Username": cells[2].textContent.trim(),
                    "Asal Sekolah/Universitas": cells[3].textContent.trim(),
                    "No Telp": cells[4].textContent.trim(),
                    "Email": cells[5].textContent.trim(),
                    "Durasi Magang": cells[6].textContent.trim(),
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

        const worksheet = XLSX.utils.json_to_sheet(data, {
            origin: "A2"
        });
        const workbook = XLSX.utils.book_new();

        // Tambah judul laporan di baris pertama
        XLSX.utils.sheet_add_aoa(worksheet, [
            ["Laporan Data Peserta Magang - AMPEL"]
        ], {
            origin: "A1"
        });

        // Tambah header manual supaya tebal
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
            }; // padding
        });
        worksheet['!cols'] = columnWidths;

        // ✅ Styling border & header bold
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

                // Header row (A2) → Bold + background
                if (R === 1) {
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

        // ✅ Simpan file Excel
        XLSX.utils.book_append_sheet(workbook, worksheet, "Peserta Magang");
        XLSX.writeFile(workbook, "Data_Peserta_Magang.xlsx");
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
                <h1>Data Peserta Magang</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Asal Sekolah/Universitas</th>
                            <th>No Telp</th>
                            <th>Email</th>
                            <th>Durasi Magang</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        // ✅ Perbaikan mapping kolom agar sesuai dengan data
        data.forEach(peserta => {
            htmlContent += `
                <tr>
                    <td>${peserta["No"]}</td>
                    <td>${peserta["Nama Lengkap"]}</td>
                    <td>${peserta["Username"]}</td>
                    <td>${peserta["Asal Sekolah/Universitas"]}</td>
                    <td>${peserta["No Telp"]}</td>
                    <td>${peserta["Email"]}</td>
                    <td>${peserta["Durasi Magang"]}</td>
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

<!-- Button unduh  -->
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
                    nama: cells[1]?.textContent.trim(),
                    username: cells[2]?.textContent.trim(),
                    pembimbing: cells[3]?.textContent.trim(),
                    asal: cells[4]?.textContent.trim(),
                    telp: cells[5]?.textContent.trim(),
                    email: cells[6]?.textContent.trim(),
                    durasi: cells[7]?.textContent.trim(),
                };

                const printWindow = window.open('', '', 'height=700,width=800');
                printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Data Peserta Magang</title>
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
                    <h1>Data Peserta Magang</h1>
                    <table>
                        <tr><td class="label">Nama Lengkap</td><td>${data.nama}</td></tr>
                        <tr><td class="label">Username</td><td>${data.username}</td></tr>
                        <tr><td class="label">Nama Pembimbing</td><td>${data.pembimbing}</td></tr>
                        <tr><td class="label">Asal Sekolah/Universitas</td><td>${data.asal}</td></tr>
                        <tr><td class="label">No Telp</td><td>${data.telp}</td></tr>
                        <tr><td class="label">Email</td><td>${data.email}</td></tr>
                        <tr><td class="label">Durasi Magang</td><td>${data.durasi}</td></tr>
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

<!-- Button edit -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".btn-success");
        const modal = document.getElementById("editModal");
        const cancelBtn = document.getElementById("cancelEdit");
        const form = document.getElementById("editForm");
        const cvInput = document.getElementById("editCv");
        const cvLink = document.getElementById("cvPreviewLink");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                const cells = row.querySelectorAll("td");

                // Ambil data dari tabel
                document.getElementById("editNama").value = cells[1].textContent.trim();
                document.getElementById("editUsername").value = cells[2].textContent.trim();
                document.getElementById("editPembimbing").value = cells[3].textContent.trim();
                document.getElementById("editAsal").value = cells[4].textContent.trim();
                document.getElementById("editTelp").value = cells[5].textContent.trim();
                document.getElementById("editEmail").value = cells[6].textContent.trim();
                document.getElementById("editDurasi").value = cells[8].textContent.trim();

                // Cek apakah ada link CV di kolom terakhir (misal di kolom ke-9)
                const cvCell = cells[9];
                if (cvCell && cvCell.querySelector("a")) {
                    const cvUrl = cvCell.querySelector("a").getAttribute("href");
                    cvLink.href = cvUrl;
                    cvLink.classList.remove("hidden");
                } else {
                    cvLink.classList.add("hidden");
                }

                modal.classList.remove("hidden");
            });
        });

        cancelBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            form.reset();
            cvLink.classList.add("hidden");
        });

        // Preview file CV baru (belum upload ke server)
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

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            alert("Perubahan data dan CV berhasil disimpan! (Simulasi)");
            modal.classList.add("hidden");
        });
    });
</script>



</html>
