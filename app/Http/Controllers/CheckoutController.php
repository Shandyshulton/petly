<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    private function splitAddress(?string $address): array
    {
        $address = trim((string) $address);

        if ($address === '') {
            return ['', ''];
        }

        $parts = array_map('trim', explode(',', $address));
        $city = count($parts) > 1 ? array_pop($parts) : '';

        return [trim(implode(', ', $parts)), $city];
    }

    private function sanitizeAddressPart(?string $value): string
    {
        return preg_replace('/\s+/', ' ', str_replace(',', ' ', trim((string) $value)));
    }

    private function formatAddress(Request $request): string
    {
        $address = $this->sanitizeAddressPart($request->input('address'));
        $city = $this->sanitizeAddressPart($request->input('city'));
        $lat = $request->input('location_lat');
        $lng = $request->input('location_lng');

        if ($lat !== null && $lng !== null && $lat !== '' && $lng !== '') {
            $address .= ' | Pin: ' . round((float) $lat, 6) . ' ' . round((float) $lng, 6);
        }

        return trim($address . ', ' . $city);
    }

    private function persistCheckoutAddress(Request $request, array $checkoutData): array
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'max:180'],
            'city' => ['required', 'string', 'max:80'],
            'location_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'location_lng' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $fullAddress = $this->formatAddress($request);
        $user = $checkoutData['user'] ?? [];

        $response = Http::withToken(session('api_token'))->post(
            config('services.petly_api.url') . '/api/profile/update-user',
            [
                'email' => $user['email'] ?? session('email'),
                'username' => $user['username'] ?? session('username'),
                'phone_number' => $user['phone_number'] ?? '',
                'address' => $fullAddress,
                'status' => null,
            ]
        );

        if (!$response->successful()) {
            return [false, 'Gagal menyimpan alamat pengiriman.'];
        }

        $checkoutData['user_detail']['address'] = $fullAddress;
        Session::put('checkout_data', $checkoutData);
        Session::put('address', $fullAddress);

        return [true, $validated];
    }

    public function storeCheckout(Request $request)
    {
        $apiToken = session('api_token');
        $customerID = session('user_id');

        if (!$apiToken || !$customerID) {
            return redirect()->route('login');
        }

        $selectedItems = $request->input('selected_items', []);

        if (!is_array($selectedItems) || empty($selectedItems)) {
            return redirect()->route('cart.index')
                ->with('failed', 'Pilih minimal satu produk untuk checkout.');
        }

        $response = Http::withToken($apiToken)->post(
            config('services.petly_api.url') . '/api/customer/transaction',
            [
                'user_id' => $customerID,
                'status_name' => 'pending',
                'cart_id' => array_values($selectedItems),
                'transaction_date' => Carbon::now()->toDateTimeString(),
            ]
        );

        if (!$response->successful()) {
            return redirect()->route('cart.index')
                ->with('failed', 'Gagal membuat transaksi.');
        }

        $data = $response->json('data');

        \Log::info('CHECKOUT API DATA', [
            'data' => $data,
        ]);

        Session::put('checkout_data', $data);

        // simpan 1x saja
        Session::put('checkout_data', $data);
        Session::put('shipping_fee', 15000);
        Session::put('payment_method', 'qris');

        return redirect()->route('checkout.index');
    }

    public function showCheckout()
    {
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('cart.index');
        }

        $shippingFee = session('shipping_fee', 15000);
        $paymentMethod = session('payment_method', 'qris');
        if (!in_array($paymentMethod, ['qris', 'va_bank'], true)) {
            $paymentMethod = 'qris';
            Session::put('payment_method', $paymentMethod);
        }
        $taxAmount = 25000;

        $transactions = $checkoutData['transactions'] ?? [];
        $carts = $checkoutData['carts'] ?? [];
        $products = $checkoutData['products'] ?? [];

        $subtotal = collect($carts)->sum('total_price');
        $transactionIds = collect($transactions)->pluck('transaction_id')->all();

        $total = $subtotal + $shippingFee + $taxAmount;

        // Alamat dari DB lokal (multi-address): aktif default, fallback ke alamat API.
        $addresses = Address::where('user_user_id', session('user_id'))
            ->orderByDesc('is_active')
            ->orderByDesc('updated_at')
            ->get();

        $activeAddress = $addresses->firstWhere('is_active', true)
            ?? $addresses->first();

        if ($activeAddress) {
            $address = $activeAddress->address;
            $city = $activeAddress->city;
        } else {
            [$address, $city] = $this->splitAddress($checkoutData['user_detail']['address'] ?? '');
        }

        return view('checkout', [
            'transactionIds' => $transactionIds,
            'subtotal'      => $subtotal,
            'products'      => $products,
            'carts'         => $carts,
            'transactions'  => $transactions,
            'user'          => $checkoutData['user'],
            'userDetail'    => $checkoutData['user_detail'],
            'shippingFee'   => $shippingFee,
            'paymentMethod'=> $paymentMethod,
            'taxAmount'     => $taxAmount,
            'total'         => $total,
            'address'       => $address,
            'city'          => $city,
            'addresses'     => $addresses,
        ]);
    }

    public function updateAddress(Request $request)
    {
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('cart.index');
        }

        [$success, $message] = $this->persistCheckoutAddress($request, $checkoutData);

        if (!$success) {
            return redirect()->route('checkout.index')->with('failed', $message);
        }

        return redirect()->route('checkout.index')->with('success', 'Alamat pengiriman berhasil disimpan.');
    }

    public function updateShipping(Request $request)
    {
        Session::put('shipping_fee', (int) $request->shipping_fee);
        return redirect()->route('checkout.index');
    }

    public function updatePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:qris,va_bank'],
        ]);

        Session::put('payment_method', $validated['payment_method']);
        return redirect()->route('checkout.index');
    }

    public function storePayment(Request $request)
    {
        $apiToken = session('api_token');
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('cart.index');
        }

        if ($request->filled('address') || $request->filled('city')) {
            [$success, $message] = $this->persistCheckoutAddress($request, $checkoutData);

            if (!$success) {
                return redirect()->route('checkout.index')->with('failed', $message);
            }

            $checkoutData = Session::get('checkout_data');
        }

        // Alamat pengiriman final: utamakan alamat aktif dari tabel `addresses` lokal,
        // fallback ke alamat di session.
        $activeAddress = Address::where('user_user_id', session('user_id'))
            ->where('is_active', true)
            ->first();

        $deliveryAddress = $activeAddress
            ? $activeAddress->address . ', ' . $activeAddress->city
            : ($checkoutData['user_detail']['address'] ?? '');

        if (empty($deliveryAddress)) {
            return redirect()->route('checkout.index')
                ->with('failed', 'Alamat belum diisi.');
        }

        $transactionIds = $request->input('transaction_ids', []);

        if (!is_array($transactionIds) || empty($transactionIds)) {
            return redirect()->route('checkout.index')
                ->with('failed', 'Tidak ada transaksi untuk diproses.');
        }

        $response = Http::withToken($apiToken)->post(
            config('services.petly_api.url') . '/api/customer/payment',
            [
                'payment_method' => $request->payment_method === 'va_bank' ? 'VA Bank' : 'QRIS',
                'delivery_class' => 'standard',
                'transaction_id' => array_values($transactionIds),
            ]
        );

        if (!$response->successful()) {
            return redirect()->route('checkout.index')
                ->with('failed', 'Pembayaran gagal.');
        }

        // bersihkan session checkout
        Session::forget(['checkout_data', 'shipping_fee', 'payment_method']);

        return redirect()->route('history')
            ->with('success', 'Order berhasil dibuat dan pembayaran diproses.');
    }

    public function resumeCheckout(Request $request)
    {
        $apiToken = session('api_token');

        if (!$apiToken) {
            return redirect()->route('login');
        }

        $transactionIds = $request->input('transaction_ids', []);

        if (!is_array($transactionIds) || empty($transactionIds)) {
            return redirect()->route('history')->with('failed', 'Tidak ada transaksi untuk dilanjutkan.');
        }

        // Ambil data transaksi user dari API
        $response = Http::withToken($apiToken)
            ->get(config('services.petly_api.url') . '/api/customer/transaction');

        if (!$response->successful()) {
            return redirect()->route('history')->with('failed', 'Gagal memuat transaksi.');
        }

        $transactions = collect($response->json('data') ?? []);

        // Filter hanya transaksi yang diminta & masih pending
        $pending = $transactions->filter(function ($t) use ($transactionIds) {
            $status = strtolower($t['transaction_status']['transaction_status_name'] ?? '');
            return in_array($t['transaction_id'], $transactionIds) && $status === 'pending';
        })->values();

        if ($pending->isEmpty()) {
            return redirect()->route('history')->with('failed', 'Transaksi sudah tidak valid (bukan pending).');
        }

        // Cek kedaluwarsa: transaksi pending > 15 menit → batalkan
        foreach ($pending as $t) {
            $created = \Carbon\Carbon::parse($t['transaction_date'] ?? null);
            if ($created->isPast() && $created->diffInMinutes(now()) >= 15) {
                Http::withToken($apiToken)->post(
                    config('services.petly_api.url') . '/api/customer/transaction-update',
                    ['transaction_id' => $t['transaction_id'], 'status_name' => 'canceled']
                );

                return redirect()->route('history')
                    ->with('failed', 'Transaksi melebihi 15 menit dan otomatis dibatalkan.');
            }
        }

        $ids = $pending->pluck('transaction_id')->all();
        $carts = $pending->pluck('cart')->flatten(1)->values();
        $products = $pending->pluck('cart.product')->flatten(1)->values();
        $user = $pending->first()['users'] ?? [];

        // Isi user_detail dari alamat aktif (tabel addresses lokal)
        $activeAddress = \App\Models\Address::where('user_user_id', session('user_id'))
            ->where('is_active', true)
            ->first();

        Session::put('checkout_data', [
            'transactions' => $pending->all(),
            'carts' => $carts->all(),
            'products' => $products->all(),
            'user' => $user,
            'user_detail' => [
                'address' => $activeAddress
                    ? $activeAddress->address . ', ' . $activeAddress->city
                    : '',
            ],
        ]);
        Session::put('shipping_fee', 15000);
        Session::put('payment_method', 'qris');

        // Simpan ID transaksi ke session agar storePayment tahu mana yang diproses
        Session::put('resume_transaction_ids', $ids);

        return redirect()->route('checkout.index')
            ->with('success', 'Lanjutkan pembayaran pesanan Anda.');
    }

    public function finish(Request $request)
    {
        $apiToken = session('api_token');

        $transactionIds = $request->input('transaction_ids', []);

        if (is_array($transactionIds)) {
            foreach ($transactionIds as $transactionId) {
                Http::withToken($apiToken)->post(
                    config('services.petly_api.url') . '/api/customer/transaction-update',
                    [
                        'transaction_id' => $transactionId,
                        'status_name' => 'canceled',
                    ]
                );
            }
        }

        Session::forget(['checkout_data', 'shipping_fee', 'payment_method']);

        return redirect()->route('history')
            ->with('success', 'Order berhasil dibatalkan.');
    }
}
