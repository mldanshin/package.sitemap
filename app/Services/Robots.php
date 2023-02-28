<?php

namespace Danshin\Sitemap\Services;

use Illuminate\Support\Facades\File;

final class Robots
{
    private string $path;
    private string $record;

    public function __construct(DomainGenarator $domain)
    {
        $this->path = public_path("robots.txt");
        $this->record = "Sitemap: " . $domain->url . "sitemap.xml";
    }

    public function write(): void
    {
        if (File::exists($this->path)) {
            $content = file_get_contents($this->path);
            if ($content === false) {
                $this->create();
                $this->append();
            } else {
                $res = $this->search($content);
                if (!$res) {
                    $this->append();
                }
            }
        } else {
            $this->create();
            $this->append();
        }
    }

    private function search(string $content): bool
    {
        if (str_contains($content, $this->record)) {
            return true;
        } else {
            return false;
        }
    }

    private function create(): void
    {
        $handle = fopen($this->path, "w");
        if ($handle === false) {
            throw new \Exception("Failed to create file {$this->path}. ");
        }

        fclose($handle);
    }

    private function append(): void
    {
        File::append($this->path, "\n");
        File::append($this->path, $this->record);
        File::append($this->path, "\n");
    }
}
