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
        <main class="flex-1 p-8 overflow-y-auto">
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
                            <div class="relative">
                                <input
                                    class="pl-4 pr-10 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    type="text" value="15/04/2026" />
                            </div>
                            <!-- Tombol urutkan -->
                            <button id="sortDateBtn"
                                class="flex items-center px-4 py-2 border rounded-md text-gray-600 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-icons text-lg mr-2">filter_list</span>
                                Urutkan sesuai tanggal
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input id="searchInput"
                                class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Masukkan Nama" type="text" />
                            <button class="bg-primary text-white px-6 py-2 rounded-md hover:bg-blue-600">CARI</button>
                        </div>
                    </div>
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="p-3">TANGGAL</th>
                                    <th class="p-3">NAMA LENGKAP</th>
                                    <th class="p-3">USERNAME</th>
                                    <th class="p-3">JAM MASUK</th>
                                    <th class="p-3">JAM PULANG</th>
                                    <th class="p-3">KETERANGAN</th>
                                    <th class="p-3 text-center">AKSI</th>
                                </tr>

                            </thead>
                            <tbody class="text-text-light dark:text-text-dark">
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <td class="p-3 text-gray-700 dark:text-gray-300">15/04/2026</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">Ade Setiawan</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">adesetiawan113</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">07:34:22</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">17:06:15</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">TEPAT WAKTU</td>
                                    <td class="p-3 text-center">
                                        <button class="p-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 bg-cyan-500 text-white rounded hover:bg-cyan-600">
                                            <span class="material-icons text-sm">download</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <td class="p-3 text-gray-700 dark:text-gray-300">15/04/2026</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">Satria Bima Nugroho</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">satriabima127</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">07:42:22</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">17:11:15</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">TEPAT WAKTU</td>
                                    <td class="p-3 text-center">
                                        <button class="p-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 bg-cyan-500 text-white rounded hover:bg-cyan-600">
                                            <span class="material-icons text-sm">download</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <td class="p-3 text-gray-700 dark:text-gray-300">15/04/2025</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">Candra Kusuma</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">candrakusuma118</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">08:02:22</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">17:07:15</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">TELAT</td>
                                    <td class="p-3 text-center">
                                        <button class="p-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                                            <span class="material-icons text-sm">visibility</span>
                                        </button>
                                        <button class="p-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            <span class="material-icons text-sm">edit</span>
                                        </button>
                                        <button class="p-1 bg-cyan-500 text-white rounded hover:bg-cyan-600">
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
        const searchInput = document.getElementById("searchInput");
        const sortDateBtn = document.getElementById("sortDateBtn");
        const showEntries = document.getElementById("showEntries");

        let filteredRows = [...allRows];
        let sortAsc = true; // untuk toggle urutan

        // Fungsi untuk render tabel sesuai filter & show
        function renderTable(data) {
            tableBody.innerHTML = "";
            const limit = parseInt(showEntries.value);
            data.slice(0, limit).forEach(row => tableBody.appendChild(row));
        }

        // 🔹 Fungsi sort berdasarkan tanggal (dd/mm/yyyy)
        function sortByDate() {
            filteredRows.sort((a, b) => {
                const tglA = a.children[0].textContent.trim();
                const tglB = b.children[0].textContent.trim();
                const [dA, mA, yA] = tglA.split("/").map(Number);
                const [dB, mB, yB] = tglB.split("/").map(Number);
                const dateA = new Date(yA, mA - 1, dA);
                const dateB = new Date(yB, mB - 1, dB);
                return sortAsc ? dateA - dateB : dateB - dateA;
            });
            sortAsc = !sortAsc; // toggle naik/turun setiap klik
            renderTable(filteredRows);
        }

        // 🔹 Fungsi pencarian berdasarkan nama
        function filterByName() {
            const keyword = searchInput.value.toLowerCase();
            filteredRows = allRows.filter(row => {
                const nama = row.children[1].textContent.toLowerCase();
                return nama.includes(keyword);
            });
            renderTable(filteredRows);
        }

        // 🔹 Event listeners
        sortDateBtn.addEventListener("click", sortByDate);
        searchInput.addEventListener("keyup", filterByName);
        showEntries.addEventListener("change", () => renderTable(filteredRows));

        // 🔹 Render awal
        renderTable(filteredRows);
    });
</script>


</html>
