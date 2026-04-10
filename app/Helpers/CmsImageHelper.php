<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CmsImageHelper
{
    protected string $imageErrorMessage = '';

    public function validateArea(
        array $area,
        bool $isRequired,
              $currentEditItem,
        Request $request,
        array $filesData,
        $modelObject
    ): array {
        $errors = [];
        $errorsAreas = [];
        $status = true;

        $field = $area['field'];
        $fieldName = $area['name'];
        $multiple = isset($area['multiple']) && $area['multiple'];

        $existingImages = [];
        if ($currentEditItem && isset($currentEditItem->{$field})) {
            $existingImages = $this->decodeStoredImages($currentEditItem->{$field});
        }

        if ($multiple) {
            $removedImages = $this->normalizeArray($request->input($field . '__removed', []));
            if (!empty($removedImages)) {
                $existingImages = array_values(array_diff($existingImages, $removedImages));
            }
        } else {
            $removeSingle = (int)$request->input($field . '__remove', 0) === 1;
            if ($removeSingle) {
                $existingImages = [];
            }
        }

        $uploadedFiles = $this->extractUploadedFiles($filesData, $field, $multiple);

        if ($isRequired && count($existingImages) === 0 && count($uploadedFiles) === 0) {
            $status = false;
            $errors[] = 'Pole: ' . $fieldName . ' jest wymagane';
            $errorsAreas[] = $field;
        }

        foreach ($uploadedFiles as $file) {
            $fileValidation = $this->validateUploadedImageFile($area, $file, $modelObject);

            if (!$fileValidation['status']) {
                $status = false;
                $errors = array_merge($errors, $fileValidation['errors']);
                $errorsAreas = array_merge($errorsAreas, $fileValidation['errorsAreas']);
            }
        }

        return [
            'status' => $status,
            'errors' => $errors,
            'errorsAreas' => array_values(array_unique($errorsAreas)),
        ];
    }

    public function prepareFieldForSave(
        array $area,
        int $recordId,
              $currentEditItem,
        Request $request,
        array $filesData,
        $modelObject
    ): array {
        $field = $area['field'];
        $multiple = isset($area['multiple']) && $area['multiple'];

        $currentValue = null;
        if ($currentEditItem && isset($currentEditItem->{$field})) {
            $currentValue = $currentEditItem->{$field};
        }

        $currentImages = $this->decodeStoredImages($currentValue);
        $uploadedFiles = $this->extractUploadedFiles($filesData, $field, $multiple);

        if ($multiple) {
            $removedImages = $this->normalizeArray($request->input($field . '__removed', []));
            $remainingImages = array_values(array_diff($currentImages, $removedImages));

            $newImages = [];
            foreach ($uploadedFiles as $file) {
                $newPathResult = $this->storeImageFile($file, $area, $recordId, $modelObject);

                if (!$newPathResult['status']) {
                    return [
                        'status' => false,
                        'errors' => $newPathResult['errors'],
                        'errorsAreas' => $newPathResult['errorsAreas'],
                        'shouldUpdate' => false,
                        'value' => null,
                    ];
                }

                $newImages[] = $newPathResult['value'];
            }

            foreach ($removedImages as $removedImage) {
                $this->deleteImageFiles($removedImage);
            }

            $finalImages = array_values(array_merge($remainingImages, $newImages));
            $shouldUpdate = !empty($removedImages) || !empty($newImages);

            return [
                'status' => true,
                'errors' => [],
                'errorsAreas' => [],
                'shouldUpdate' => $shouldUpdate,
                'value' => count($finalImages) > 0
                    ? json_encode($finalImages, JSON_UNESCAPED_SLASHES)
                    : null,
            ];
        }

        $removeSingle = (int)$request->input($field . '__remove', 0) === 1;

        if (count($uploadedFiles) > 0) {
            $newPathResult = $this->storeImageFile($uploadedFiles[0], $area, $recordId, $modelObject);

            if (!$newPathResult['status']) {
                return [
                    'status' => false,
                    'errors' => $newPathResult['errors'],
                    'errorsAreas' => $newPathResult['errorsAreas'],
                    'shouldUpdate' => false,
                    'value' => null,
                ];
            }

            if (!empty($currentValue)) {
                $this->deleteImageFiles($currentValue);
            }

            return [
                'status' => true,
                'errors' => [],
                'errorsAreas' => [],
                'shouldUpdate' => true,
                'value' => $newPathResult['value'],
            ];
        }

        if ($removeSingle) {
            if (!empty($currentValue)) {
                $this->deleteImageFiles($currentValue);
            }

            return [
                'status' => true,
                'errors' => [],
                'errorsAreas' => [],
                'shouldUpdate' => true,
                'value' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'shouldUpdate' => false,
            'value' => null,
        ];
    }

    public function deleteImagesFromStoredValue($value): void
    {
        $images = $this->decodeStoredImages($value);

        foreach ($images as $image) {
            $this->deleteImageFiles($image);
        }
    }

    public function decodeStoredImages($value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        return [$value];
    }

    private function validateUploadedImageFile(array $area, $file, $modelObject): array
    {
        $errors = [];
        $errorsAreas = [];
        $status = true;

        if (!$file || !$file->isValid()) {
            return [
                'status' => false,
                'errors' => ['Nie udało się odczytać przesłanego pliku: ' . $area['name']],
                'errorsAreas' => [$area['field']],
            ];
        }

        $allowedExtensions = array_map('strtolower', $modelObject->getImageAllowedExtensions($area));
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            $status = false;
            $errors[] = 'Pole: ' . $area['name'] . ' ma niedozwolony format pliku';
            $errorsAreas[] = $area['field'];
        }

        $maxSizeMb = (int)$modelObject->getImageMaxSizeMb($area);
        if ($file->getSize() > ($maxSizeMb * 1024 * 1024)) {
            $status = false;
            $errors[] = 'Pole: ' . $area['name'] . ' przekracza maksymalny rozmiar ' . $maxSizeMb . ' MB';
            $errorsAreas[] = $area['field'];
        }

        return [
            'status' => $status,
            'errors' => $errors,
            'errorsAreas' => $errorsAreas,
        ];
    }

    private function extractUploadedFiles(array $filesData, string $field, bool $multiple): array
    {
        if (!isset($filesData[$field])) {
            return [];
        }

        if ($multiple) {
            return is_array($filesData[$field])
                ? array_values(array_filter($filesData[$field]))
                : [];
        }

        return [$filesData[$field]];
    }

    private function normalizeArray($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value, function ($item) {
                return $item !== null && $item !== '';
            }));
        }

        if ($value === null || $value === '') {
            return [];
        }

        return [$value];
    }

    private function storeImageFile($file, array $area, int $recordId, $modelObject): array
    {
        if (!$file || !$file->isValid()) {
            return [
                'status' => false,
                'errors' => ['Nie udało się zapisać pliku'],
                'errorsAreas' => [$area['field']],
                'value' => null,
            ];
        }

        $uploadPath = $modelObject->getImageUploadPath($area);
        $baseUploadDirRelative = trim($uploadPath, '/');
        $recordDirRelative = $baseUploadDirRelative . '/' . $recordId;
        $recordDirAbsolute = public_path($recordDirRelative);

        if (!File::exists($recordDirAbsolute)) {
            File::makeDirectory($recordDirAbsolute, 0755, true);
        }

        $originalClientName = trim($file->getClientOriginalName());
        $originalClientName = str_replace(['\\', '/'], '-', $originalClientName);

        if ($originalClientName === '') {
            $originalClientName = 'plik.' . strtolower($file->getClientOriginalExtension());
        }

        $extension = strtolower(pathinfo($originalClientName, PATHINFO_EXTENSION));
        $baseName = pathinfo($originalClientName, PATHINFO_FILENAME);

        if ($baseName === '') {
            $baseName = 'plik';
        }

        $availableNames = $this->getAvailableImageNames($recordDirAbsolute, $baseName, $extension);

        $finalOriginalFileName = $availableNames['original'];
        $finalWebpFileName = $availableNames['webp'];

        $file->move($recordDirAbsolute, $finalOriginalFileName);

        $originalRelativePath = '/' . trim($recordDirRelative . '/' . $finalOriginalFileName, '/');
        $originalAbsolutePath = public_path(ltrim($originalRelativePath, '/'));

        $webpRelativePath = '/' . trim($recordDirRelative . '/' . $finalWebpFileName, '/');
        $webpAbsolutePath = public_path(ltrim($webpRelativePath, '/'));

        $webpResult = $this->generateWebpCopy($originalAbsolutePath, $webpAbsolutePath);

        if (!$webpResult) {
            if (File::exists($originalAbsolutePath)) {
                File::delete($originalAbsolutePath);
            }

            return [
                'status' => false,
                'errors' => [
                    'Nie udało się wygenerować wersji WEBP dla pola: '
                    . $area['name']
                    . '. '
                    . $this->imageErrorMessage
                ],
                'errorsAreas' => [$area['field']],
                'value' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'value' => $originalRelativePath,
        ];
    }

    private function generateWebpCopy(string $sourcePath, string $destinationPath): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        if (!file_exists($sourcePath)) {
            $this->imageErrorMessage = 'Plik źródłowy nie istnieje: ' . $sourcePath;
            return false;
        }

        if ($extension === 'webp') {
            if ($sourcePath === $destinationPath) {
                return true;
            }

            if (!copy($sourcePath, $destinationPath)) {
                $this->imageErrorMessage = 'Nie udało się skopiować pliku WEBP';
                return false;
            }

            return true;
        }

        if (!extension_loaded('gd')) {
            $this->imageErrorMessage = 'Rozszerzenie GD nie jest włączone';
            return false;
        }

        if (!function_exists('imagewebp')) {
            $this->imageErrorMessage = 'PHP GD nie obsługuje funkcji imagewebp()';
            return false;
        }

        $imageResource = null;

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (!function_exists('imagecreatefromjpeg')) {
                    $this->imageErrorMessage = 'Brak funkcji imagecreatefromjpeg()';
                    return false;
                }
                $imageResource = @imagecreatefromjpeg($sourcePath);
                if (!$imageResource) {
                    $this->imageErrorMessage = 'Nie udało się odczytać pliku JPG/JPEG';
                    return false;
                }
                break;

            case 'png':
                if (!function_exists('imagecreatefrompng')) {
                    $this->imageErrorMessage = 'Brak funkcji imagecreatefrompng()';
                    return false;
                }
                $imageResource = @imagecreatefrompng($sourcePath);
                if (!$imageResource) {
                    $this->imageErrorMessage = 'Nie udało się odczytać pliku PNG';
                    return false;
                }

                imagepalettetotruecolor($imageResource);
                imagealphablending($imageResource, true);
                imagesavealpha($imageResource, true);
                break;

            default:
                $this->imageErrorMessage = 'Nieobsługiwane źródło do konwersji na WEBP: ' . $extension;
                return false;
        }

        $result = imagewebp($imageResource, $destinationPath, 85);
        imagedestroy($imageResource);

        if (!$result) {
            $this->imageErrorMessage = 'imagewebp() zwróciło false';
            return false;
        }

        if (!file_exists($destinationPath)) {
            $this->imageErrorMessage = 'Plik WEBP nie został utworzony';
            return false;
        }

        return true;
    }

    private function deleteImageFiles(?string $relativePath): void
    {
        if ($relativePath === null || $relativePath === '') {
            return;
        }

        $originalAbsolute = public_path(ltrim($relativePath, '/'));
        $webpAbsolute = public_path(
            preg_replace('/\.[^.]+$/', '.webp', ltrim($relativePath, '/'))
        );

        $filesToDelete = array_unique([$originalAbsolute, $webpAbsolute]);

        foreach ($filesToDelete as $filePath) {
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }

    private function getAvailableImageNames(string $directoryAbsolute, string $baseName, string $extension): array
    {
        $counter = 1;

        while (true) {
            $suffix = $counter === 1 ? '' : '-' . $counter;

            $originalFileName = $baseName . $suffix . '.' . $extension;
            $webpFileName = $baseName . $suffix . '.webp';

            $originalPath = $directoryAbsolute . DIRECTORY_SEPARATOR . $originalFileName;
            $webpPath = $directoryAbsolute . DIRECTORY_SEPARATOR . $webpFileName;

            if (!File::exists($originalPath) && !File::exists($webpPath)) {
                return [
                    'original' => $originalFileName,
                    'webp' => $webpFileName,
                ];
            }

            $counter++;
        }
    }
}
