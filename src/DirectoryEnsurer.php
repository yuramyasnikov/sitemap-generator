<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

trait DirectoryEnsurer
{
    private function ensureDirectoryForFile(string $filePath): bool
    {
        return is_dir(dirname($filePath)) ?: mkdir(dirname($filePath), 0777, true);
    }
}