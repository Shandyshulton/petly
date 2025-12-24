<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="h-full">
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-16 bg-white flex flex-col items-center py-4 shadow-sm">
            <div class="mb-8">
                <img src="/img/logopet.png" alt="Petty Logo" class="w-10 h-7">
            </div>
            <div class="flex flex-col items-center gap-8">
                {{-- <a href="/admin/dashboard" class="p-2 rounded-lg bg-pink-50 hover:bg-pink-100 transition-colors">
                    <i class="ri-pie-chart-line text-pink-400 text-gray-400 text-xl"></i>
                </a> --}}
                <a href="/admin/product" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-shopping-bag-3-line text-gray-400 text-xl"></i>
                </a>
                <a href="/admin/order" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-shopping-cart-line text-gray-400 text-xl"></i>
                </a>
                <a href="/admin/user" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-group-line text-gray-400 text-xl"></i>
                </a>
            </div>
            <div class="mt-auto">
                <a href="/" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-settings-line text-gray-400 text-xl"></i>
                </a>
            </div>
        </div>


        <div class="mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-4 ml-3">Overview</h1>

            <div class="grid lg:grid-cols-5 gap-10 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-500">Today's Revenue</p>
                    <p class="text-xl font-bold">IDR xxxxxxxxx</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-500">Total Sales</p>
                    <p class="text-xl font-bold">xxxxx</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-500">Total Products</p>
                    <p class="text-xl font-bold">xxxx</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-500">Total Stocks</p>
                    <p class="text-xl font-bold">xxx</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-500">Active Users</p>
                    <p class="text-xl font-bold">xxxx</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Quantity of Products Sold</h2>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Transaction History</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-[#4e4e4e] text-md">
                            <th class="py-3 px-4 text-left">Transaction ID</th>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Amount</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4">TRxxx</td>
                            <td class="py-3 px-4">xxx xx, xxx</td>
                            <td class="py-3 px-4">xxxxx</td>
                            <td class="py-3 px-4">
                                <span class="bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full">In
                                    Progress</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4">TRxxx</td>
                            <td class="py-3 px-4">xxx xx, xxx</td>
                            <td class="py-3 px-4">xxxxx</td>
                            <td class="py-3 px-4">
                                <span
                                    class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">Confirmed</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4">TRxxx</td>
                            <td class="py-3 px-4">xxx xx, xxx</td>
                            <td class="py-3 px-4">xxxxx</td>
                            <td class="py-3 px-4">
                                <span
                                    class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">Confirmed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch('/api/line-chart')
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById('salesChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Sales',
                                    data: data.data,
                                    borderColor: 'red',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                }]
                            }
                        });
                    });
            });
        </script>

</body>

<body class="bg-gray-100 p-6">

</body>

</html>
