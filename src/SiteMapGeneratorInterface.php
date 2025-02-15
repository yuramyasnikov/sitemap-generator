<?php

namespace Yura\SitemapGenerator;

interface SiteMapGeneratorInterface
{
    public function generate(array $pages, string $outputPath): void;
}