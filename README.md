## Last Modified

<img src="https://preview.dragon-code.pro/TheDragonCode/last-modified.svg?brand=laravel" alt="Laravel Last Modified"/>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

> Setting the response code 304 Not Modified in the absence of content changes.


## Installation

To get the latest version of `Last Modified` simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require dragon-code/last-modified
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "dragon-code/last-modified": "^2.0"
    }
}
```

And call `php artisan vendor:publish --provider="DragonCode\LastModified\ServiceProvider"` command.

> Note
>
> If you were using version 2.0 or less, run the `php artisan migrate` command.
> If this is your first time here, then you do not need to install this command, since, starting from version [2.1](https://github.com/TheDragonCode/last-modified/releases/tag/v2.1.0), we refused to store data in the database, replacing the storage with a cache. 

Next, add middleware in `$middlewareGroups > web` section in `app/Http/Kernel.php` file:

```php
use DragonCode\LastModified\Middlewares\CheckLastModified;

protected $middlewareGroups = [
    'web' => [
         CheckLastModified::class,
    ]
]
```

**IMPORTANT!** It's recommended to add a middleware after `CheckForMaintenanceMode::class`.

The system works like this: when opening a page, the middleware checks if there is an entry in the database table about this link. If there is, it checks the `Last-Modified` header
key and returns either 200 or 304 code.

To add records to the table, it is recommended to create a console command in your application using the following example:

### Upgrade from `andrey-helldar/last-modified`

1. Replace `"andrey-helldar/last-modified": "^1.0"` with `"dragon-code/last-modified": "^2.0"` in the `composer.json` file;
2. If you don't use auto-discovery, replace the `Helldar\LastModified\ServiceProvider` with `DragonCode\LastModified\ServiceProvider`;
3. Replace the `Helldar\LastModified\Middlewares\CheckLastModified` middleware with `DragonCode\LastModified\Middlewares\CheckLastModified`;
4. Replace the `new Helldar\LastModified\Services\LastModified` class with `DragonCode\LastModified\Services\LastModified::make()`:
   > Before:
   > ```php
   > (new LastModified)
   >      ->collections(...)
   >      ->builders(...)
   >      ->models(...)
   >      ->manuals(...)
   >      ->update(bool $force = false);
   > ```
   > After:
   > ```php
   > LastModified::make()
   >      ->collections(...)
   >      ->builders(...)
   >      ->models(...)
   >      ->manual(...)
   >      ->update();
   > ```
5. Replace the `new Helldar\LastModified\Services\LastItem` class with `DragonCode\LastModified\Resources\Item::make()`:
   > Before:
   > ```php
   > new LastItem('http://example.com/foo', Carbon::now());
   > new LastItem('http://example.com/baz?id=1');
   > ```
   > After:
   > ```php
   > Item::make(['url' => 'http://example.com/foo', 'updated_at' => Carbon::now()])
   > Item::make(['url' => 'http://example.com/baz?id=1', 'updated_at' => Carbon::now()])
   > ```
6. Call the `composer update` console command.

## Create / Update

```php
use Carbon\Carbon;
use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;

public function handle()
{
    $collection_1 = Foo::whereIsActive(true)->get();
    $collection_2 = Bar::where('id', '>', 50)->get();
    $collection_3 = Baz::query()->get();

    $builder_1 = Foo::whereIsActive(true);
    $builder_2 = Bar::where('id', '>', 50);
    $builder_3 = Baz::query();
    
    $model_1 = Foo::whereIsActive(true)->first();
    $model_2 = Bar::where('id', '>', 50)->first();
    $model_3 = Baz::query()->first();
    
    $item_1 = Item::make(['url' => 'https://example.com/foo',      'updated_at' => Carbon::now());
    $item_2 = Item::make(['url' => 'https://example.com/bar',      'updated_at' => Carbon::parse('2018-03-02'));
    $item_3 = Item::make(['url' => 'https://example.com/baz?id=1', 'updated_at' => Carbon::now());
    
    LastModified::make()
        ->collections($collection_1, $collection_2, $collection_3)
        ->builders($builder_1, $builder_2, $builder_3)
        ->models($model_1, $model_2, $model_3)
        ->manual($item_1, $item_2, $item_3)
        ->update();
}
```

**IMPORTANT!** The `url` attribute must be available for models.

If the model has no attribute `url`, it should be created.

For example:

```php
protected getUrlAttribute(): string
{
    $slug = $this->slug;

    return route('page.show', compact('slug'));
}
```

## Delete

```php
use Carbon\Carbon;
use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;

public function handle()
{    
    $collection_1 = Foo::whereIsActive(false)->get();
    $collection_2 = Bar::whereIn('id', [50, 60, 62, 73])->get();

    $builder_1 = Foo::whereIsActive(true);
    $builder_2 = Bar::where('id', '>', 50);
    $builder_3 = Baz::query();
    
    $model_1 = Foo::whereIsActive(false)->first();
    $model_2 = Bar::whereIn('id', [50, 60, 62, 73])->first();
    
    $item_1 = Item::make(['url' => 'https://example.com/foo', 'updated_at' => Carbon::now()]);
    $item_2 = Item::make(['url' => 'https://example.com/bar', 'updated_at' => Carbon::now()]);
    
    LastModified::make()
        ->collections($collection_1, $collection_2, $collection_3)
        ->builders($builder_1, $builder_2, $builder_3)
        ->models($model_1, $model_2, $model_3)
        ->manual($item_1, $item_2, $item_3)
        ->delete();
}
```

## Clean

You can also completely delete all saved key labels with one command:

```php
use DragonCode\LastModified\Services\LastModified;

LastModified::make()->flush();
```

## Observer

In order to reduce the load on the database and free up the crown queue, it is recommended to use the observer to update the records:

```php
namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use DragonCode\LastModified\Services\LastModified;

class LastModifiedObserver
{
    public function saving(Model $model)
    {
        LastModified::make()
            ->models($model)
            ->update();
    }

    public function deleting(Model $model)
    {
        LastModified::make()
            ->models($model)
            ->delete();
    }
}
```

Don't forget to add the link to the service provider:

```php
namespace App\Providers;

use App\Observers\LastModifiedObserver;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Page::observe(LastModifiedObserver::class);
        News::observe(LastModifiedObserver::class);

        // ...
    }
}
```

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/workflow/status/TheDragonCode/last-modified/phpunit?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/last-modified.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/last-modified.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/last-modified?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/TheDragonCode/last-modified/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/last-modified
