<?php

namespace TsfCorp\MysqlLock;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class MysqlLockServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mysqllock', function ($app) {
            return new MysqlLock($app->make(Connection::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'mysqllock',
        ];
    }
}