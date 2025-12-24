document.addEventListener("DOMContentLoaded", function () {
    lucide.createIcons(); // Initialize Lucide icons

    document.getElementById("bank-account-section").addEventListener("click", function (event) {
        if (event.target.id === "add-bank-btn") {
            showBankForm();
        } else if (event.target.id === "cancel-btn") {
            showBankForm();
        } else if (event.target.id === "save-btn") {
            showSavedAccount();
        }
    });
});

function showBankForm() {
    document.getElementById("bank-account-section").innerHTML = `
        <h2 class="text-lg font-semibold mb-4">Debit Card</h2>
        <div class="space-y-4">
            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                <input id="card-number" type="password" class="w-3/4 p-2 border rounded-lg" placeholder="••••  ••••  ••••">
                <img src="img/BCA_logo.png" alt="BCA" class="h-6">
            </div>
            <div class="grid grid-cols-4 gap-4">
                <input id="exp-date" type="text" class="p-2 border rounded-lg" placeholder="MM/YY">
                <input id="cvv" type="password" class="p-2 border rounded-lg" placeholder="CVV">
                <input id="zip" type="text" class="col-span-2 p-2 border rounded-lg" placeholder="Zip Code">
            </div>
            <div class="flex items-center gap-2">
                <input id="save-card" type="checkbox" class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                <label class="text-gray-700">Save this debit card for later use</label>
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <button id="cancel-btn" class="px-6 py-3 border rounded-lg text-gray-700">Cancel</button>
            <button id="save-btn" class="px-6 py-3 bg-green-500 text-white rounded-lg">Save this Payment</button>
        </div>
    `;
}

function showSavedAccounts() {
    document.getElementById("bank-account-section").innerHTML = `
        <h2 class="text-lg font-semibold mb-4">You can save max. 3 bank accounts</h2>
        <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500 border border-gray-300">
            You Don't Have Any Payment Method Right Now
        </div>
        <button id="add-bank-btn" class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700 font-semibold">
            Add new bank account
        </button>
    `;
}

function saveBankAccount() {
    const cardNumber = document.getElementById("card-number").value;
    const expDate = document.getElementById("exp-date").value;
    const cvv = document.getElementById("cvv").value;
    const zip = document.getElementById("zip").value;

    if (!cardNumber || !expDate || !cvv || !zip) {
        alert("Please fill in all required fields.");
        return;
    }

    document.getElementById("bank-account-section").innerHTML = `
        <h2 class="text-lg font-semibold mb-4">You can save max. 3 bank accounts</h2>
        <div class="space-y-4">
            <div class="flex justify-between items-center bg-gray-50 p-5 rounded-lg shadow">
                <div>
                    <img src="img/BCA_logo.png" alt="BCA" class="h-6 mb-2">
                    <p class="font-semibold">PT. BCA (BANK CENTRAL ASIA) TBK</p>
                    <p class="text-gray-600">**** **** **** ${cardNumber.slice(-4)}</p>
                    <p class="text-gray-600">Exp: ${expDate}</p>
                </div>
                <button class="bg-red-400 p-3 rounded-lg text-white">
                    <i data-lucide="trash-2"></i>
                </button>
            </div>
        </div>
        <button id="add-bank-btn" class="w-full mt-5 p-4 border border-gray-300 rounded-lg text-gray-700 font-semibold">
            Add new bank account
        </button>
    `;
}
