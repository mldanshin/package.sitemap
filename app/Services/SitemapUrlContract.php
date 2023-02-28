<?php

namespace Danshin\Sitemap\Services;

use Danshin\Sitemap\Models\DTO\SitemapUrl;
use Illuminate\Support\Collection;

interface SitemapUrlContract
{
    /**
     * @return Collection|SitemapUrl[]
     */
    public function get(): Collection;
}
