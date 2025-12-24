<script src="https://unpkg.com/lucide@latest"></script>
<script src="{{ asset('js/bank-account.js') }}" defer></script>
<x-main>
    <div class="flex gap-12 max-w-7xl w-full mt-12 mb-32 mx-auto flex-grow">
        <aside class="bg-white shadow-md rounded-xl p-6 w-80 flex flex-col items-center self-start">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>
            <nav class="space-y-4 w-full">
                <a href="/profile"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="user"></i> User Info
                </a>
                <a href="/bank"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group">
                    <i data-lucide="landmark"></i> Bank Account
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
                {{-- <a href="/pet" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="dog"></i> Add Pet
                </a> --}}
                <a href="/theme"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>
            <div class="border-t w-full mt-6 pt-4">
                <a href="#" class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                    <i data-lucide="log-out"></i> Logout
                </a>
            </div>
        </aside>
        <main class="flex-1">
            <div id="bank-account-section" class="bg-white p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full">
                <h2 class="text-lg font-semibold mb-4">You can save max. 3 bank accounts</h2>
                <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500 border border-gray-300">
                    You Don't Have Any Payment Method Right Now
                </div>
                <button onclick="showBankForm()"
                    class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700 font-semibold">
                    Add new bank account
                </button>
            </div>
        </main>
    </div>

    <script>
        function showBankForm() {
            document.getElementById('bank-account-section').innerHTML = `
                <h2 class="text-lg font-semibold mb-4">Debit Card</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                        <input type="password" class="w-3/4 p-2 border rounded-lg" placeholder="••••  ••••  ••••" disabled>
                        <img src="{{ URL('img/BCA_logo.png') }}" alt="BCA" class="h-6">
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <input type="text" class="p-2 border rounded-lg" placeholder="04 / 03" disabled>
                        <input type="password" class="p-2 border rounded-lg" placeholder="•••" disabled>
                        <input type="text" class="col-span-2 p-2 border rounded-lg" placeholder="58295" disabled>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                        <label class="text-gray-700">Save this debit card for later use</label>
                    </div>
                    <label class="block text-gray-700">Street Address</label>
                    <input type="text" class="w-full p-2 border rounded-lg">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700">Apt Number</label>
                            <input type="text" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">State</label>
                            <input type="text" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Zip</label>
                            <input type="text" class="w-full p-2 border rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <button onclick="showSavedAccounts()" class="px-6 py-3 border rounded-lg text-gray-700">Cancel</button>
                    <button class="px-6 py-3 bg-green-500 text-white rounded-lg">Save this Payment</button>
                </div>`;
            lucide.createIcons(); // Reinitialize icons
        }

        function showSavedAccounts() {
            document.getElementById('bank-account-section').innerHTML = `
                <h2 class="text-lg font-semibold mb-4">You can save max. 3 bank accounts</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-gray-50 p-5 rounded-lg shadow">
                        <div>
                            <img src="{{ URL('img/BCA_logo.png') }}" alt="BCA" class="h-6 mb-2">
                            <p class="font-semibold">PT. BCA (BANK CENTRAL ASIA) TBK</p>
                            <p class="text-gray-600">9829xxxxxx</p>
                            <p class="text-gray-600">a.n JONI SUTEDJA</p>
                        </div>
                        <button class="bg-red-400 p-3 rounded-lg text-white">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </div>
                </div>
                <button onclick="showBankForm()" class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700">
                    Add new bank account
                </button>`;
            lucide.createIcons();
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

</x-main>
