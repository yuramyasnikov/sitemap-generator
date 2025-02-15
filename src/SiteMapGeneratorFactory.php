<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

use RuntimeException;

class SiteMapGeneratorFactory
{
    /**
     * @param string $format
     * @return SiteMapGeneratorInterface
     * @throws RuntimeException
     */
    public static function create(string $format): SiteMapGeneratorInterface
    {
        return match (strtolower($format)) {
            'xml' => new XmlSiteMapGenerator(),
            'csv' => new CsvSiteMapGenerator(),
            'json' => new JsonSiteMapGenerator(),
            default => throw new RuntimeException('Неизвестный формат'),
        };
    }
}