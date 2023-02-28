# Генератор карты сайта
Создаёт файл карты сайта public/sitemap.xml, если файл существует, то будет перезаписан. 
Создаёт файл public/robots.txt, если файл существует, в него добавляется строчка о расположении карты сайта.  
Добавление команды в планировщик, позваляет автоматизировать генерацию карты сайта.  

## Требования
- PHP 8.3 или выше  
- Laravel 11.0  или выше
- Composer  

## Инструкция для установки
Добавьте в файл composer.json  

    "require": {
        "mldanshin/package-sitemap": "^1.0"
    }

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mldanshin/package-sitemap"
        }
    ]

Выполните

    composer update

Укажите в файле .env значение APP_URL

Реализуйте интерфейс Danshin\Sitemap\Services\SitemapUrlContract,

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


например так

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

Создайте поставщика для созданного класса. Например так

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

Добавьте поставщика в файл конфигурации config/app.php

    'providers' => [
        Danshin\Sitemap\Providers\ExampleServiceProvider::class
    ]

Или добавьте в метод register класса AppServiceProvider, например так

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

## Использование

Выполнение команды генерирует файл карты сайта

    php artisan sitemap:generate

Добавьте выполнение команды в планировщик заданий, для автоматической генерации карты сайта.

## Лицензия

Программное обеспечение с открытым исходным кодом, лицензированное в соответствии с [MIT license](https://opensource.org/licenses/MIT).