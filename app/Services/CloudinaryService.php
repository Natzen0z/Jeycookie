<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Upload an image to Cloudinary.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return array{public_id: string, url: string, secure_url: string}
     */
    public function upload(UploadedFile $file, string $folder = 'products'): array
    {
        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => "jeycookie/{$folder}",
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);

        return [
            'public_id' => $result->getPublicId(),
            'url' => $result->getSecurePath(),
            'secure_url' => $result->getSecurePath(),
        ];
    }

    /**
     * Delete an image from Cloudinary.
     *
     * @param string $publicId
     * @return bool
     */
    public function delete(string $publicId): bool
    {
        try {
            Cloudinary::destroy($publicId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Generate an optimized Cloudinary URL with transformations.
     *
     * @param string $publicId
     * @param array $options
     * @return string
     */
    public function url(string $publicId, array $options = []): string
    {
        $defaultOptions = [
            'quality' => 'auto',
            'fetch_format' => 'auto',
        ];

        $options = array_merge($defaultOptions, $options);

        return cloudinary()->getUrl($publicId, $options);
    }

    /**
     * Generate a thumbnail URL.
     *
     * @param string $publicId
     * @param int $width
     * @param int $height
     * @return string
     */
    public function thumbnail(string $publicId, int $width = 300, int $height = 300): string
    {
        return $this->url($publicId, [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'gravity' => 'auto',
        ]);
    }

    /**
     * Check if an image path is a Cloudinary public ID.
     *
     * @param string|null $image
     * @return bool
     */
    public function isCloudinaryImage(?string $image): bool
    {
        if (empty($image)) {
            return false;
        }

        // Cloudinary public IDs typically start with the folder name
        return str_starts_with($image, 'jeycookie/');
    }

    /**
     * Get the full URL for an image (handles both local and Cloudinary).
     *
     * @param string|null $image
     * @param array $options
     * @return string|null
     */
    public function getImageUrl(?string $image, array $options = []): ?string
    {
        if (empty($image)) {
            return null;
        }

        // If it's a Cloudinary image
        if ($this->isCloudinaryImage($image)) {
            return $this->url($image, $options);
        }

        // If it's a full URL already
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // Fallback to local storage
        return asset('storage/' . $image);
    }
}
