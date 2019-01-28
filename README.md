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
        "andrey-helldar/last-modified": "^1.0"
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

In the configuration file, you can specify the name of the connection.


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
```php
use Helldar\LastModified\Services\LastModified;

public function handle() {
    $model_1 = Foo::whereIsActive(true)->get();
    $model_2 = Bar::where('id', '>', 50)->get();
    $model_3 = Baz::query()->get();
    
    (new LastModified)
        ->models($model_1, $model_2, $model_3);
}
```

**IMPORTANT!** Attributes `url` and `updated_at` must be available for models.

If the model has no attribute `url`, it should be created.

For example:
```php
protected getUrlAttribute() {
    return route('company.show', [$this->slug]);
}
```

Using the console command is optional. You can also create, for example, events or observers to update the data in the table.


## Copyright and License

`Last Modified` package was written by Andrey Helldar for the Laravel framework 5.6 or above, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
