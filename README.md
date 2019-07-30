## Last Modified

Setting the response code 304 Not Modified in the absence of content changes.


<p align="center">
    <a href="https://styleci.io/repos/167387916"><img src="https://styleci.io/repos/167387916/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/last-modified"><img src="https://img.shields.io/packagist/dt/andrey-helldar/last-modified.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/last-modified"><img src="https://poser.pugx.org/andrey-helldar/last-modified/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/last-modified"><img src="https://poser.pugx.org/andrey-helldar/last-modified/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/last-modified/license?format=flat-square" alt="License" /></a>
</p>


## Installation

To get the latest version of `Last Modified` simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/last-modified
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/last-modified": "^1.3"
    }
}
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in `app/Providers/AppServiceProvider.php`:

```php
public function register()
{
    $this->app->register(\Helldar\LastModified\ServiceProvider::class);
}
```

or update `providers` section in your `config/app.php` file:
```php
'providers' => [
    // ...
    
    \Helldar\LastModified\ServiceProvider::class,
    
    // ...
]
```

And call `php artisan vendor:publish --provider="Helldar\LastModified\ServiceProvider"` command, and `php artisan migrate` to create table in database.

Next, add middleware in `$middlewareGroups > web` section in `app/Http/Kernel.php` file:
```php

protected $middlewareGroups = [
    'web' => [
        Helldar\LastModified\CheckLastModified::class,
    ]
]
```

**IMPORTANT!** It's recommended to add a middleware after `CheckForMaintenanceMode::class`.

The system works like this: when opening a page, the middleware checks if there is an entry in the database table about this link. If there is, it checks the `Last-Modified` header key and returns either 200 or 304 code.

To add records to the table, it is recommended to create a console command in your application using the following example:

##### For creating/updating items:
```php
use Helldar\LastModified\Services\LastModified;
use Helldar\LastModified\Services\LastItem;

public function handle() {
    $collection_1 = Foo::whereIsActive(true)->get();
    $collection_2 = Bar::where('id', '>', 50)->get();
    $collection_3 = Baz::query()->get();

    $builder_1 = Foo::whereIsActive(true);
    $builder_2 = Bar::where('id', '>', 50);
    $builder_3 = Baz::query();
    
    $model_1 = Foo::whereIsActive(true)->first();
    $model_2 = Bar::where('id', '>', 50)->first();
    $model_3 = Baz::query()->first();
    
    $item_1 = new LastItem('http://example.com/foo', Carbon::now());
    $item_2 = new LastItem('http://example.com/bar', Carbon::parse('2018-03-02'));
    $item_3 = new LastItem('http://example.com/baz');
    
    (new LastModified)
        ->collections($collection_1, $collection_2, $collection_3)
        ->builders($builder_1, $builder_2, $builder_3)
        ->models($model_1, $model_2, $model_3)
        ->manuals($item_1, $item_2, $item_3)
        ->update(bool $force = false);
}
```

##### For deleting items:
```php
use Helldar\LastModified\Services\LastModified;
use Helldar\LastModified\Services\LastItem;

public function handle() {    
    $collection_1 = Foo::whereIsActive(false)->get();
    $collection_2 = Bar::whereIn('id', [50, 60, 62, 73])->get();

    $builder_1 = Foo::whereIsActive(true);
    $builder_2 = Bar::where('id', '>', 50);
    $builder_3 = Baz::query();
    
    $model_1 = Foo::whereIsActive(false)->first();
    $model_2 = Bar::whereIn('id', [50, 60, 62, 73])->first();
    
    $item_1 = new LastItem('http://example.com/foo');
    $item_2 = new LastItem('http://example.com/bar');
    
    (new LastModified)
        ->collections($collection_1, $collection_2, $collection_3)
        ->builders($builder_1, $builder_2, $builder_3)
        ->models($model_1, $model_2, $model_3)
        ->manuals($item_1, $item_2, $item_3)
        ->delete(bool $force = false);
}
```

**IMPORTANT!** The `url` attribute must be available for models.

If the model has no attribute `url`, it should be created.

For example:
```php
protected getUrlAttribute() {
    return route('company.show', [$this->slug]);
}
```

Using the console command is optional. You can also create, for example, events or observers to update the data in the table.

See example in [gist](https://gist.github.com/andrey-helldar/7051619379a98c8335af15cc0fb5bf6f).


##### Absolute or relative URLs

If your application is multi-domain, you can set page refresh labels without regard to the domain name.

Example:

when `absolute_url` is `true`:

|url|md5|returned date|
|---|---|---|
|https://example1.com/foo/bar/baz|8b023041767447ece63485467a0eb3f2|2019-02-08 12:34:47|
|https://example2.com/foo/bar/baz|e61e56084eba741df97ca6ea2c46c8f8|2018-03-15 01:67:17|

when `absolute_url` is `false`:

|url|md5|returned date|
|---|---|---|
|https://example1.com/foo/bar/baz|7c709be36bd82265bb0eb74a233f3040|2019-02-08 12:34:47|
|https://example2.com/foo/bar/baz|7c709be36bd82265bb0eb74a233f3040|2019-02-08 12:34:47|

By default, the package uses an absolute link.

## Copyright and License

`Last Modified` package was written by Andrey Helldar for the Laravel framework 5.6 or above, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
