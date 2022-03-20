# Laravel-flysystem-kodo

<p align="center">
    <a href="https://packagist.org/packages/larva/laravel-flysystem-kodo"><img src="https://poser.pugx.org/larva/laravel-flysystem-kodo/v/stable" alt="Stable Version"></a>
    <a href="https://packagist.org/packages/larva/laravel-flysystem-kodo"><img src="https://poser.pugx.org/larva/laravel-flysystem-kodo/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/larva/laravel-flysystem-kodo"><img src="https://poser.pugx.org/larva/laravel-flysystem-kodo/license" alt="License"></a>
</p>

适用于 Laravel 的七牛 Kodo 适配器，完整支持七牛 Kodo 所有方法和操作。

## 安装

```bash
composer require larva/laravel-flysystem-kodo -vv
```

修改配置文件: `config/filesystems.php`

添加一个磁盘配置

```php
'kodo' => [
    'driver'     => 'kodo',
    'access_key' => env('QINIU_ACCESS_KEY'),
    'secret_key' => env('QINIU_SECRET_KEY'),
    'bucket' => env('QINIU_BUCKET'),
    'root' => env('QINIU_PREFIX'), // optional
    'url' => env('QINIU_BUCKET_URL'),
    'visibility' => 'private',
],
```

修改默认存储驱动

```php
    'default' => 'kodo'
```

## 使用

参见 [Laravel wiki](https://laravel.com/docs/9.x/filesystem)
