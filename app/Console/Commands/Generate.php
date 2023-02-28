<?php

namespace Danshin\Sitemap\Console\Commands;

use Illuminate\Console\Command;
use Danshin\Sitemap\Services\Sitemap;
use Danshin\Sitemap\Services\SitemapUrlContract;
use Danshin\Sitemap\Services\Robots;

final class Generate extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap';

    public function __construct(
        private Sitemap $sitemap,
        private Robots $robots
    ) {
        parent::__construct();
    }

    /**
        * Execute the console command.
    *
    * @return mixed
    */
    public function handle(SitemapUrlContract $url)
    {
        $this->sitemap->create($url);
        $this->robots->write();
        $this->info("sitemap:generate OK");
        return 0;
    }
}
