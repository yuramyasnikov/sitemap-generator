<?php

use PHPUnit\Framework\TestCase;
use Yura\SitemapGenerator\ChangeFreqEnum;
use Yura\SitemapGenerator\CsvSiteMapGenerator;
use Yura\SitemapGenerator\JsonSiteMapGenerator;
use Yura\SitemapGenerator\Page;
use Yura\SitemapGenerator\SiteMapGeneratorFactory;
use Yura\SitemapGenerator\XmlSiteMapGenerator;

class SiteMapGeneratorTest extends TestCase
{
    private $pages = [];

    protected function setUp(): void
    {
        $this->pages = [
            new Page(url: 'https://example.com/', lastMod: new \DateTimeImmutable('2023-10-01 00:00:00'), changeFreq: ChangeFreqEnum::Weekly, priority: 1.0),
            new Page(url: 'https://example.com/about', lastMod: new \DateTimeImmutable('2023-09-15'), changeFreq: ChangeFreqEnum::Monthly, priority: 0.8),
            new Page(url: 'https://example.com/contact'),
        ];
    }

    public function testXmlGeneration()
    {
        $generator = new XmlSiteMapGenerator();
        $outputPath = sys_get_temp_dir() . '/sitemap.xml';

        $generator->generate($this->pages, $outputPath);

        $this->assertFileExists($outputPath);

        $content = file_get_contents($outputPath);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString('<loc>https://example.com/</loc>', $content, "В файле должен быть url указывающий на главную страницу");
        $this->assertStringContainsString('<lastmod>2023-10-01 00:00:00</lastmod>', $content);
        unlink($outputPath); 
    }

    public function testCsvGeneration()
    {
        $generator = new CsvSiteMapGenerator();
        $outputPath = sys_get_temp_dir() . '/sitemap.csv';

        $generator->generate($this->pages, $outputPath);

        $this->assertFileExists($outputPath);

        $content = file_get_contents($outputPath);
        $this->assertStringContainsString('URL,"Last Modified","Change Frequency",Priority', $content, "В csv файле должен быть заголовок");
        $this->assertStringContainsString('https://example.com/,"2023-10-01 00:00:00",weekly,1', $content, "В csv файле мы долдны увидеть url указывающий на главную страницу, с датой 2023-10-01 00:00:00, и приоритетом 1");
        unlink($outputPath); 
    }

    public function testJsonGeneration()
    {
        $generator = new JsonSiteMapGenerator();
        $outputPath = sys_get_temp_dir() . '/sitemap.json';

        $generator->generate($this->pages, $outputPath);

        $this->assertFileExists($outputPath);

        $content = file_get_contents($outputPath);
        $data = json_decode($content, true);

        $this->assertEquals('https://example.com/', $data[0]['url'], "В файле должен быть url указывающий на главную страницу");
        $this->assertEquals('2023-10-01 00:00:00', $data[0]['lastmod']);
        $this->assertEquals('weekly', $data[0]['changefreq']);
        $this->assertEquals('1.0', $data[0]['priority']);

        unlink($outputPath); 
    }

    public function testUnsupportedFormat()
    {
        $this->expectException(\RuntimeException::class);
        $factory = new SiteMapGeneratorFactory();
        $generator = $factory::create('unsupported');
    }


}