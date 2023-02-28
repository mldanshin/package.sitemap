<?php

namespace Danshin\Sitemap\Models\DTO;

final class SitemapUrl
{
    public readonly string $urn;
    public readonly \DateTime $lastmod;
    public readonly string $changefreq;
    public readonly float $priority;

    public function __construct(string $urn, \DateTime $lastmod, string $changefreq, float $priority)
    {
        $this->urn = $urn;
        $this->lastmod = $lastmod;
        $this->changefreq = $changefreq;
        $this->priority = $priority;
    }
}
