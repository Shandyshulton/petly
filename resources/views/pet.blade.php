<script src="https://unpkg.com/lucide@latest"></script>
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
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="landmark"></i> Bank Account
                </a>
                <a href="/pet"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group">
                    <i data-lucide="dog"></i> Add Pet
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
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
            <div id="pet-section" class="bg-white p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full">
                <h2 class="text-lg font-semibold mb-4">You don't have any pets right now</h2>
                <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500 border border-gray-300">
                    No pets added yet
                </div>
                <button onclick="showPetForm()"
                    class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700 font-semibold">
                    Add a pet
                </button>
            </div>
        </main>
    </div>
    <script>
        function showPetForm() {
            document.getElementById('pet-section').innerHTML = `
                <h2 class="text-lg font-semibold mb-4">Enter your pet's details</h2>
                <div class="space-y-4">
                    <input type="text" class="w-full p-2 border rounded-lg" placeholder="Pet Name">
                    <input type="text" class="w-full p-2 border rounded-lg" placeholder="Breed">
                    <select class="w-full p-2 border rounded-lg">
                        <option value="male">Male ♂</option>
                        <option value="female">Female ♀</option>
                    </select>
                </div>
                <div class="flex justify-between mt-6">
                    <button onclick="showNoPets()" class="px-6 py-3 border rounded-lg text-gray-700">Cancel</button>
                    <button class="px-6 py-3 bg-green-500 text-white rounded-lg">Save Pet</button>
                </div>`;
        }

        function showNoPets() {
            document.getElementById('pet-section').innerHTML = `
                <h2 class="text-lg font-semibold mb-4">You don't have any pets right now</h2>
                <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500 border border-gray-300">
                    No pets added yet
                </div>
                <button onclick="showPetForm()" class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700">
                    Add a pet
                </button>`;
        }
    </script>
    <script>
        lucide.createIcons();
    </script>
</x-main>

<!-- <x-main>  //for the pet
<body class="bg-gray-100 flex min-h-screen items-center justify-center p-6">

    <div class="flex gap-10 max-w-6xl w-full">
        <aside class="bg-white shadow-md rounded-xl p-6 w-80 flex flex-col items-center self-start">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>
            <nav class="space-y-4 w-full">
                <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="user"></i> User Info
                </a>
                <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="banknote"></i> Bank Account
                </a>
                <a href="#" class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group">
                    <i data-lucide="paw-print"></i> Add Pet
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
                <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>
            <div class="border-t w-full mt-6 pt-4">
                <a href="#" class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                    <i data-lucide="log-out"></i> Logout
                </a>
            </div>
        </aside>

        <main class="flex-1 flex justify-center items-center">
            <div class="bg-white p-6 rounded-xl shadow-md max-w-3xl w-full">
                <h2 class="text-lg font-semibold mb-4">Enter the animal you have</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                        <div class="flex items-center gap-4">
                            <img src="{{ URL('img/cat1you.png') }}" alt="Timmy" class="w-16 h-16 rounded-full object-cover">
                            <div>
                                <p class="font-semibold">TIMMY</p>
                                <p class="text-gray-600">British Short Hair</p>
                                <p class="text-gray-600">Female <span class="text-pink-500">♀</span></p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="bg-red-400 p-3 rounded-lg text-white">
                                <i data-lucide="pencil"></i>
                            </button>
                            <button class="bg-red-400 p-3 rounded-lg text-white">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                        <div class="flex items-center gap-4">
                            <img src="{{ URL('img/cat2you.png') }}" alt="Coco" class="w-16 h-16 rounded-full object-cover">
                            <div>
                                <p class="font-semibold">COCO</p>
                                <p class="text-gray-600">Corgi</p>
                                <p class="text-gray-600">Male <span class="text-blue-500">♂</span></p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="bg-red-400 p-3 rounded-lg text-white">
                                <i data-lucide="pencil"></i>
                            </button>
                            <button class="bg-red-400 p-3 rounded-lg text-white">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button class="w-full mt-4 p-3 border border-gray-300 rounded-lg text-gray-700">
                    Add some pet
                </button>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons(); // Load Lucide Icons
    </script>

</body>
</x-main> -->
