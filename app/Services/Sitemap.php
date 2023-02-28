<?php

namespace Danshin\Sitemap\Services;

use Danshin\Sitemap\Models\DTO\SitemapUrl;
use Spatie\Sitemap\Sitemap as SpatieSitemap;
use Spatie\Sitemap\Tags\Url;

final class Sitemap
{
    private string $path;
    private string $url;

    public function __construct(DomainGenarator $domain)
    {
        $this->path = public_path("sitemap.xml");
        $this->url = $domain->url;
    }

    public function create(SitemapUrlContract $urls): void
    {
        $sitemap = SpatieSitemap::create();

        foreach ($urls->get() as $url) {
            $this->add($url, $sitemap);
        }

        $sitemap->writeToFile($this->path);
    }

    private function add(SitemapUrl $sitemapUrl, SpatieSitemap &$sitemap): void
    {
        $url = $this->url . $sitemapUrl->urn;
        $sitemap->add(
            Url::create($url)
            ->setLastModificationDate($sitemapUrl->lastmod)
            ->setChangeFrequency($sitemapUrl->changefreq)
            ->setPriority($sitemapUrl->priority)
        );
    }
}
