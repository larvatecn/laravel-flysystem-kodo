<?php

namespace Larva\Flysystem\Qiniu;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\FilesystemOperator;
use Qiniu\Auth;

/**
 * OSS 适配器
 * @author Tongle Xu <xutongle@msn.com>
 */
class KodoAdapter extends FilesystemAdapter
{
    /**
     * The qiniu Auth.
     *
     * @var Auth
     */
    protected Auth $auth;

    /**
     * Create a new AwsS3V3FilesystemAdapter instance.
     *
     * @param FilesystemOperator $driver
     * @param QiniuKodoAdapter $adapter
     * @param array $config
     * @param Auth $auth
     */
    public function __construct(FilesystemOperator $driver, QiniuKodoAdapter $adapter, array $config, Auth $auth)
    {
        parent::__construct($driver, $adapter, $config);
        $this->auth = $auth;
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param string $path
     * @return string
     */
    public function url($path): string
    {
        $visibility = $this->getVisibility($path);
        if ($visibility == FilesystemContract::VISIBILITY_PRIVATE) {
            return $this->temporaryUrl($path, Carbon::now()->addMinutes(5), []);
        } else {
            return $this->concatPathToUrl($this->config['url'], $this->prefixer->prefixPath($path));
        }
    }

    /**
     * Get a temporary URL for the file at the given path.
     *
     * @param string $path
     * @param \DateTimeInterface $expiration
     * @param array $options
     * @return string
     */
    public function temporaryUrl($path, $expiration, array $options = []): string
    {
        $location = $this->prefixer->prefixPath($path);
        $timeout = $expiration->getTimestamp() - time();
        return $this->auth->privateDownloadUrl($this->config['url'] . '/' . ltrim($location, '/'), $timeout);
    }

    /**
     * Get the underlying Kodo client.
     *
     * @return Auth
     */
    public function getClient(): Auth
    {
        return $this->auth;
    }
}
