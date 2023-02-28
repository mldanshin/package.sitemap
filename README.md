# Site Map Generator
Creates a sitemap file public/sitemap.xml if the file exists, it will be overwritten.  
Creates a file public/robots.txt if the file exists, a line about the location of the site map is added to it.  
Adding a command to the scheduler allows you to automate the generation of the site map.  

## Requirements
- PHP 8.3 or higher  
- Laravel 11.0  or higher
- Composer  

## Installation Instructions
Add to the file composer.json  

    "require": {
        "mldanshin/package-sitemap": "^1.0"
    }

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mldanshin/package-sitemap"
        }
    ]

Execute

    composer update

Specify in the file .env value of APP_URL

Implement the interface Danshin\Sitemap\Services\SitemapUrlContract,

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


for example so

    namespace Danshin\Sitemap\Services;

    use Danshin\Sitemap\Models\DTO\SitemapUrl;
    use Danshin\Sitemap\Services\Changefreq;
    use Danshin\Sitemap\Services\SitemapUrlContract;
    use Illuminate\Support\Collection;

    final class SitemapUrlExample implements SitemapUrlContract
    {
        /**
        * @return Collection|SitemapUrl[]
        */
        public function get(): Collection
        {
            $collection = collect();
            $collection->push(new SitemapUrl(
                "",
                new \DateTime(),
                Changefreq::WEEKLY,
                0.5
            ));
            $collection->push(new SitemapUrl(
                "blabla",
                new \DateTime(),
                Changefreq::WEEKLY,
                0.5
            ));
            return $collection;
        }
    }

Create a provider for the created class. For example so

    namespace Danshin\Sitemap\Providers;

    use Danshin\Sitemap\Services\SitemapUrlContract;
    use Danshin\Sitemap\Services\SitemapUrlExample;
    use Illuminate\Support\ServiceProvider;

    final class ExampleServiceProvider extends ServiceProvider
    {
        /**
        * Register any application services.
        *
        * @return void
        */
        public function register()
        {
            $this->app->bind(SitemapUrlContract::class, function ($app) {
                return new SitemapUrlExample();
            });
        }
    }

Add the vendor to the configuration file config/app.php

    'providers' => [
        Danshin\Sitemap\Providers\ExampleServiceProvider::class
    ]

Or add to the register method of the App Service Provider class, for example like this

    use Danshin\Sitemap\Services\SitemapUrlContract;
    use Danshin\Sitemap\Services\SitemapUrl;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SitemapUrlContract::class, function () {
            return new SitemapUrl();
        });
    }

## Using

Executing the command generates a sitemap file

    php artisan sitemap:generate

Add the execution of the command to the task scheduler, for automatic generation of the site map.

## License

Open source software licensed in accordance with [MIT license](https://opensource.org/licenses/MIT).