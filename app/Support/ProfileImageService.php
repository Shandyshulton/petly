<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProfileImageService
{
    private const DIRECTORY = 'profile-images';

    private const MAX_FILE_SIZE = 3 * 1024 * 1024; // 3MB

    public function store(UploadedFile $image, ?string $currentPath = null): string
    {
        $image = $this->resizeIfNeeded($image);

        $directory = public_path(self::DIRECTORY);
        File::ensureDirectoryExists($directory);

        $uploadedHash = hash_file('sha256', $image->getRealPath());

        if ($currentPath && $this->isLocalProfileImage($currentPath)) {
            $currentFullPath = public_path(ltrim($currentPath, '/'));

            if (File::exists($currentFullPath) && hash_file('sha256', $currentFullPath) === $uploadedHash) {
                return $currentPath;
            }
        }

        foreach (File::files($directory) as $file) {
            if (hash_file('sha256', $file->getPathname()) === $uploadedHash) {
                $existingPath = '/' . self::DIRECTORY . '/' . $file->getFilename();
                $this->deleteIfUnused($currentPath, $existingPath);

                return $existingPath;
            }
        }

        $newPath = '/' . self::DIRECTORY . '/' . $this->makeFilename($image);
        $image->move($directory, basename($newPath));
        $this->deleteIfUnused($currentPath, $newPath);

        return $newPath;
    }

    public function deleteIfUnused(?string $path, ?string $replacementPath = null): void
    {
        if (!$path || $path === $replacementPath || !$this->isLocalProfileImage($path)) {
            return;
        }

        $isUsed = User::where('profile_image', $path)->exists();

        if ($isUsed) {
            return;
        }

        $fullPath = public_path(ltrim($path, '/'));

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    private function resizeIfNeeded(UploadedFile $image): UploadedFile
    {
        if ($image->getSize() <= self::MAX_FILE_SIZE) {
            return $image;
        }

        $imagePath = $image->getRealPath();
        $extension = strtolower($image->getClientOriginalExtension() ?: $image->extension() ?: 'jpg');

        if ($extension === 'webp') {
            $source = @imagecreatefromwebp($imagePath);
        } elseif ($extension === 'png') {
            $source = @imagecreatefrompng($imagePath);
        } else {
            $source = @imagecreatefromjpeg($imagePath);
        }

        if (!$source) {
            return $image;
        }

        $width = imagesx($source);
        $height = imagesy($source);

        $maxDimension = 512;
        $scale = min(1, $maxDimension / max($width, $height));
        $newWidth = (int) round($width * $scale);
        $newHeight = (int) round($height * $scale);

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        if ($extension === 'png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);

        $tempPath = tempnam(sys_get_temp_dir(), 'profile_') . '.' . $extension;
        $saved = match ($extension) {
            'webp' => imagewebp($resized, $tempPath, 85),
            'png' => imagepng($resized, $tempPath, 7),
            default => imagejpeg($resized, $tempPath, 85),
        };
        imagedestroy($resized);

        if (!$saved || !file_exists($tempPath)) {
            return $image;
        }

        return new UploadedFile(
            $tempPath,
            $image->getClientOriginalName(),
            $image->getClientMimeType(),
            null,
            true
        );
    }

    private function makeFilename(UploadedFile $image): string
    {
        $extension = strtolower($image->getClientOriginalExtension() ?: $image->extension() ?: 'jpg');
        $baseName = 'profile-' . now()->format('ymd');
        $filename = "{$baseName}.{$extension}";
        $counter = 2;

        while (File::exists(public_path(self::DIRECTORY . '/' . $filename))) {
            $filename = "{$baseName}-{$counter}.{$extension}";
            $counter++;
        }

        return $filename;
    }

    private function isLocalProfileImage(string $path): bool
    {
        return str_starts_with($path, '/' . self::DIRECTORY . '/');
    }
}
