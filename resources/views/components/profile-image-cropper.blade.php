{{-- Self-contained profile image cropper.
     Renders: preview image + choose button + cropper modal.
     The cropped result is placed into a hidden file input named "profile_image"
     so the enclosing <form enctype="multipart/form-data"> submits it normally.

     Usage:
       <form ... enctype="multipart/form-data">
           <x-profile-image-cropper
               name="profile_image"
               :image="$user->profile_image"
               fallback="/img/default.png"
               size="w-24 h-24"
               inputId="profile_image"
           />
       </form>
--}}

@once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
@endonce

@php
    $name = $name ?? 'profile_image';
    $inputId = $inputId ?? 'profile_image_input';
    $previewId = $previewId ?? 'profile_image_preview';
    $hiddenId = $hiddenId ?? 'profile_image_hidden';
    $modalId = $modalId ?? 'profile_image_modal';
    $imageId = $imageId ?? 'profile_image_crop';
    $confirmId = $confirmId ?? 'profile_image_confirm';
    $cancelId = $cancelId ?? 'profile_image_cancel';
    $size = $size ?? 'w-24 h-24';
    $compact = $compact ?? false;
    $src = $image ? asset($image) : ($fallback ?? '');
@endphp

@if (!$compact)
    <div class="flex items-center gap-4">
        <img id="{{ $previewId }}" src="{{ $src }}" alt="Preview"
            class="{{ $size }} shrink-0 rounded-full border-2 border-white object-cover shadow-sm">

        <div class="flex-1">
            <input type="file" id="{{ $inputId }}" accept="image/jpeg,image/png,image/webp"
                class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-[#FE9494] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-[#FE7A7A]">
            <p class="mt-1.5 text-xs text-gray-400">JPG, PNG, or WebP. Crop your photo before saving.</p>
            @error($name)
                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
@else
    <input type="file" id="{{ $inputId }}" class="hidden" accept="image/jpeg,image/png,image/webp">
@endif

<input type="file" name="{{ $name }}" id="{{ $hiddenId }}" class="hidden" accept="image/jpeg,image/png,image/webp">

{{-- Cropper modal --}}
<div id="{{ $modalId }}" style="display:none"
    class="fixed inset-0 z-50 items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-lg rounded-xl bg-white p-4 shadow-xl">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800">Crop Photo</h3>
            <button type="button" id="{{ $cancelId }}" class="text-gray-400 hover:text-gray-600">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        <div class="overflow-hidden rounded-lg bg-gray-900">
            <img id="{{ $imageId }}" alt="Crop preview" class="block max-h-[60vh] w-full">
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <button type="button" id="{{ $cancelId }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="{{ $confirmId }}"
                class="rounded-lg bg-[#FE9494] px-4 py-2 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                Crop & Use
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('{{ $inputId }}');
        const previewImg = document.getElementById('{{ $previewId }}');
        const modal = document.getElementById('{{ $modalId }}');
        const image = document.getElementById('{{ $imageId }}');
        const confirmBtn = document.getElementById('{{ $confirmId }}');
        const cancelBtns = document.querySelectorAll('#{{ $modalId }} [id="{{ $cancelId }}"]');
        const hiddenInput = document.getElementById('{{ $hiddenId }}');

        let cropper = null;
        let selectedFile = null;

        function openModal() {
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            selectedFile = file;

            const reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result;
                openModal();

                if (cropper) cropper.destroy();
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        });

        confirmBtn.addEventListener('click', function () {
            if (!cropper) return;

            cropper.getCroppedCanvas({ width: 512, height: 512 }).toBlob(function (blob) {
                const newFile = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(newFile);

                previewImg.src = URL.createObjectURL(blob);
                hiddenInput.files = dataTransfer.files;

                closeModal();

                @if (isset($onConfirm))
                    window['{{ $onConfirm }}']();
                @endif
            }, 'image/jpeg', 0.9);
        });

        cancelBtns.forEach(function (btn) {
            btn.addEventListener('click', closeModal);
        });
    });
</script>
