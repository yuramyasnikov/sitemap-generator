<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

use SimpleXMLElement;
use Yura\SitemapGenerator\SiteMapGeneratorInterface;

final class XmlSiteMapGenerator implements SiteMapGeneratorInterface
{

    #[\Override] public function generate(array $pages, string $outputPath): void
    {
        $xml = new SimpleXMLElement('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        foreach ($pages as $page) {
            /** @var Page $page */
            $url = $xml->addChild('url');
            $url->addChild('loc', htmlspecialchars($page->getUrl()));
            $url->addChild('lastmod', $page->getLastMod()->format('Y-m-d H:i:s'));
            $url->addChild('changefreq', $page->getChangeFreq()->value);
            $url->addChild('priority', strval($page->getPriority()));
        }
        file_put_contents($outputPath, $xml->asXML());
    }
}