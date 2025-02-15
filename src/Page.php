<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

/**
 * @param string $url
 * @param \DateTimeImmutable $lastMod
 * @param ChangeFreqEnum $changeFreq
 * @param float $priority
 */
final class Page
{
    public function __construct(
        private string $url,
        private ?\DateTimeImmutable $lastMod = null,
        private ?ChangeFreqEnum $changeFreq = null,
        private float $priority = 0.5,
    ) {
        if($this->priority < 0 || $this->priority > 1) {
            throw new \Exception('Указано некоректное значение для priority: ' . (string) $this->priority);
        }
        if(!$this->lastMod) {
            $this->lastMod = new \DateTimeImmutable();
        }
        if(!$this->changeFreq) {
            $this->changeFreq = ChangeFreqEnum::Monthly;
        }
    }

    public function getUrl(): string 
    {
        return $this->url;
    }

    public function getLastMod(): \DateTimeImmutable
    {
        return $this->lastMod;
    }

    public function getChangeFreq(): ChangeFreqEnum
    {
        return $this->changeFreq;
    }

    public function getPriority(): float 
    {
        return $this->priority;
    }
}