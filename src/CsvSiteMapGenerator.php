<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

use Yura\SitemapGenerator\SiteMapGeneratorInterface;

final class CsvSiteMapGenerator implements SiteMapGeneratorInterface
{
    /** 
     * @var array<Page> $pages
     */
    #[\Override] public function generate(array $pages, string $outputPath): void
    {
        $file = fopen($outputPath, 'w');
        fputcsv($file, ['URL', 'Last Modified', 'Change Frequency', 'Priority']);
        foreach ($pages as $page) {
            /** @var Page $page */
            fputcsv($file, [
                $page->getUrl(),
                $page->getLastMod()->format('Y-m-d H:i:s'),
                $page->getChangeFreq()->value,
                $page->getPriority()
            ]);
        }
        fclose($file);
    }
}