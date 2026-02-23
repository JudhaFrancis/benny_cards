<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPhotoUrl
{
    protected function normalizeUrl(?string $value): string
    {
        if (!$value) {
            return '';
        }

        // If it's already a full URL with the correct base, return it
        if (str_starts_with($value, 'http') && str_contains($value, 'localhost/benny-cards-admin-panel')) {
            return $value;
        }

        $baseUrl = env('VITE_IMAGE_BASE_URL', '');
        // Remove trailing slash from base url
        $baseUrl = rtrim($baseUrl, '/');

        $path = $value;

        // Handle full URLs from old domain (strip them)
        if (str_starts_with($path, 'http')) {
            // Option A: Try to extract the relative path after typical folders
            $parts = explode('/', $path);
            // Find known folders like 'photos', 'uploads', 'storage'
            $index = -1;
            foreach ($parts as $key => $part) {
                if (in_array($part, ['photos', 'uploads', 'storage'])) {
                    $index = $key;
                    break;
                }
            }

            if ($index !== -1) {
                $path = implode('/', array_slice($parts, $index));
            } else {
                // Fallback: strip protocol and domain
                $path = preg_replace('/^https?:\/\/[^\/]+\//', '', $path);
            }
        }

        // Clean leading slash
        $path = ltrim($path, '/');

        // If path starts with 'uploads/', and base url ends with 'uploads', strip one
        if (str_starts_with($path, 'uploads/') && str_ends_with($baseUrl, '/uploads')) {
            $path = substr($path, 8); // remove 'uploads/'
        }

        return "{$baseUrl}/{$path}";
    }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $this->normalizeUrl($value),
        );
    }

    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $this->normalizeUrl($value),
        );
    }
}
