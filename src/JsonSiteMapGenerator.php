<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

use Yura\SitemapGenerator\SiteMapGeneratorInterface;

final class JsonSiteMapGenerator implements SiteMapGeneratorInterface
{
    use DirectoryEnsurer;

    #[\Override] public function generate(array $pages, string $outputPath): void
    {
        $data = array_map(static function(Page $page) {
            return [
                'url'        => $page->getUrl(),
                'lastmod'    => $page->getLastMod()->format('Y-m-d H:i:s'),
                'changefreq' => $page->getChangeFreq()->value,
                'priority'   => $page->getPriority()
            ];
        }, $pages);

        $this->ensureDirectoryForFile($outputPath);
        file_put_contents($outputPath, json_encode($data, JSON_PRETTY_PRINT));
    }
}