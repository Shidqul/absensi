<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan peserta magang</title>
    {{-- ✅ Ambil favicon dari partial --}}
    @include('partials.favicon')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
</head>

<body class="font-display bg-background-light dark:bg-background-dark">
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
        <main class="flex-1 p-8 ">
            <!-- Header: Judul & Tombol Export -->
            <h1 class="text-xl text-text-light dark:text-text-dark font-semibold mb-6">Laporan</h1>
            <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow">
                <div class="bg-indigo-900 text-white p-4">
                    <h2 class="text-xl font-semibold">Laporan Peserta Magang</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="relative">
                            <select id="laporanSelect"
                                class="w-48 appearance-none bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-md py-2 pl-3 pr-10 text-text-light dark:text-text-dark focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <option value="/laporanmagang">Laporan Magang</option>
                                <option value="/laporan">Pengajuan Izin</option>
                            </select>
                        </div>
                        <!-- Filter & Search -->
                        <input type="date" value="2026-04-26">
                        <i class="fas fa-filter mb-4" style="color: #666; cursor: pointer;"></i>
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

                    <!-- table -->
                    <div class="overflow-x-auto ">
                        <table class="min-w-full">
                            <thead class="bg-primary text-white">
                                <tr class="bg-table-header-light dark:bg-table-header-dark text-white">
                                    <th class="py-3 px-4 text-left">TANGGAL</th>
                                    <th class="py-3 px-4 text-left">NAMA LENGKAP</th>
                                    <th class="py-3 px-4 text-left">USERNAME</th>
                                    <th class="py-3 px-4 text-left">SUBJEK</th>
                                    <th class="py-3 px-4 text-left">WAKTU KIRIM</th>
                                    <th class="py-3 px-4 text-left">STATUS</th>
                                    <th class="py-3 px-4 text-left">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="text-text-light dark:text-text-dark">
                                <tr>
                                    <td class="py-3 px-4">02/05/2026</td>
                                    <td class="py-3 px-4">Ade Setiawan</td>
                                    <td class="py-3 px-4">adesetiawan113</td>
                                    <td class="py-3 px-4">Laporan Magang 2 Mei 2026</td>
                                    <td class="py-3 px-4">16:23:15</td>
                                    <td class="py-3 px-4">DITERIMA</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button class="p-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 rounded bg-green-500 text-white hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 rounded bg-primary text-white hover:bg-opacity-90">
                                            <span class="material-icons text-sm">download</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <td class="py-3 px-4">02/05/2026</td>
                                    <td class="py-3 px-4">Bagus Putra Irwanto</td>
                                    <td class="py-3 px-4">bagusputra18</td>
                                    <td class="py-3 px-4">Laporan Magang 2 Mei 2026</td>
                                    <td class="py-3 px-4">16:28:15</td>
                                    <td class="py-3 px-4">DITERIMA</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button class="p-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 rounded bg-green-500 text-white hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 rounded bg-primary text-white hover:bg-opacity-90">
                                            <span class="material-icons text-sm">download</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4">02/05/2026</td>
                                    <td class="py-3 px-4">Friska Dewi Gerania</td>
                                    <td class="py-3 px-4">friskadewi122</td>
                                    <td class="py-3 px-4">Laporan Magang 2 Mei 2026</td>
                                    <td class="py-3 px-4">16:28:15</td>
                                    <td class="py-3 px-4">DITERIMA</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button class="p-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 rounded bg-green-500 text-white hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 rounded bg-primary text-white hover:bg-opacity-90">
                                            <span class="material-icons text-sm">download</span>
                                        </button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("table tbody");
        const allRows = Array.from(tableBody.querySelectorAll("tr"));
        const searchInput = document.querySelector('input[type="search"]');
        const searchForm = document.querySelector('form[role="search"]');
        const showSelect = document.getElementById("show-entries");
        const laporanSelect = document.getElementById("laporanSelect");

        let filteredRows = [...allRows]; // semua baris awal

        // 🔹 Fungsi render tabel
        function renderTable(data) {
            tableBody.innerHTML = "";
            const limit = parseInt(showSelect.value);
            data.slice(0, limit).forEach(row => tableBody.appendChild(row));
        }

        // 🔹 Fungsi filter nama
        function filterRows() {
            const keyword = searchInput.value.toLowerCase();
            filteredRows = allRows.filter(row => {
                const nama = row.children[1].textContent.toLowerCase();
                return nama.includes(keyword);
            });
            renderTable(filteredRows);
        }

        // 🔹 Event: ketika mengetik di kolom pencarian
        searchInput.addEventListener("keyup", filterRows);

        // 🔹 Event: tombol CARI diklik (form submit)
        searchForm.addEventListener("submit", function(e) {
            e.preventDefault(); // cegah reload
            filterRows();
        });

        // 🔹 Event: ketika dropdown show entries berubah
        showSelect.addEventListener("change", () => renderTable(filteredRows));

        // 🔹 Event: ketika dropdown laporan berubah halaman
        laporanSelect.addEventListener("change", function() {
            window.location.href = this.value;
        });

        // 🔹 Render tabel awal
        renderTable(filteredRows);
    });
</script>


</html>
