<?php

namespace Larva\Flysystem\Qiniu;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Visibility;
use Qiniu\Auth;

/**
 * 阿里云OSS服务提供
 */
class ObjectStorageServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->app->make('filesystem')->extend('kodo', function ($app, $config) {
            $root = (string)($config['root'] ?? '');
            $config['directory_separator'] = '/';
            $visibility = new PortableVisibilityConverter($config['visibility'] ?? Visibility::PUBLIC);
            $auth = new Auth($config['access_key'], $config['secret_key']);
            $adapter = new QiniuKodoAdapter($auth, $config['bucket'], $root, $visibility, null, $config['options'] ?? []);

            return new KodoAdapter(
                new Flysystem($adapter, Arr::only($config, [
                    'directory_visibility',
                    'disable_asserts',
                    'temporary_url',
                    'url',
                    'visibility',
                ])),
                $adapter,
                $config,
                $auth
            );
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
