@php
    $toastType = session('success') ? 'success' : (session('failed') || session('error') || $errors->any() ? 'failed' : null);
    $toastMessage = session('success')
        ?? session('failed')
        ?? session('error')
        ?? ($errors->any() ? $errors->first() : null);
@endphp

<div id="petly-toast"
    class="fixed right-4 top-4 z-[9999] hidden w-[min(24rem,calc(100vw-2rem))] translate-y-[-8px] rounded-lg border bg-white p-4 opacity-0 shadow-xl transition-all duration-300"
    role="status" aria-live="polite">
    <div class="flex gap-3">
        <div id="petly-toast-icon"
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full">
            <svg id="petly-toast-success-icon" class="hidden h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <svg id="petly-toast-failed-icon" class="hidden h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p id="petly-toast-title" class="text-sm font-semibold text-gray-900"></p>
            <p id="petly-toast-message" class="mt-1 break-words text-sm text-gray-600"></p>
        </div>
        <button type="button" id="petly-toast-close"
            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-700"
            aria-label="Close notification">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
    </div>
</div>

<script>
    (function () {
        const toast = document.getElementById('petly-toast');
        const title = document.getElementById('petly-toast-title');
        const message = document.getElementById('petly-toast-message');
        const iconWrap = document.getElementById('petly-toast-icon');
        const successIcon = document.getElementById('petly-toast-success-icon');
        const failedIcon = document.getElementById('petly-toast-failed-icon');
        const close = document.getElementById('petly-toast-close');
        let timer = null;

        window.petlyToast = function (type, text, options = {}) {
            const isSuccess = type === 'success';

            clearTimeout(timer);
            title.textContent = isSuccess ? 'Success' : 'Failed';
            message.textContent = text;

            toast.classList.remove('border-green-200', 'border-red-200', 'bg-green-50', 'bg-red-50');
            iconWrap.classList.remove('bg-green-100', 'bg-red-100', 'text-green-600', 'text-red-600');

            toast.classList.add(isSuccess ? 'border-green-200' : 'border-red-200');
            toast.classList.add(isSuccess ? 'bg-green-50' : 'bg-red-50');
            iconWrap.classList.add(isSuccess ? 'bg-green-100' : 'bg-red-100');
            iconWrap.classList.add(isSuccess ? 'text-green-600' : 'text-red-600');
            successIcon.classList.toggle('hidden', !isSuccess);
            failedIcon.classList.toggle('hidden', isSuccess);

            toast.classList.remove('hidden');
            requestAnimationFrame(function () {
                toast.classList.remove('translate-y-[-8px]', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            timer = setTimeout(window.petlyHideToast, options.duration || 3200);
        };

        window.petlyHideToast = function () {
            toast.classList.add('translate-y-[-8px]', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
            setTimeout(function () {
                toast.classList.add('hidden');
            }, 300);
        };

        window.petlyRequireLogin = function (redirectUrl) {
            window.petlyToast('failed', 'Please login first to use the cart.', { duration: 1800 });
            setTimeout(function () {
                window.location.href = redirectUrl;
            }, 900);
        };

        close.addEventListener('click', window.petlyHideToast);

        @if ($toastType && $toastMessage)
            window.addEventListener('DOMContentLoaded', function () {
                window.petlyToast(@json($toastType), @json($toastMessage));
            });
        @endif
    })();
</script>
