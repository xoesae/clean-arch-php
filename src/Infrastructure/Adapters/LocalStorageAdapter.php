<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters;

use App\Application\Contracts\Storage;

class LocalStorageAdapter implements Storage
{
    public function store(string $filename, string $path, string $content): bool
    {
        return file_put_contents($path . DIRECTORY_SEPARATOR . $filename, $content) !== false;
    }
}
