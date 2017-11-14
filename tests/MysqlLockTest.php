<?php

namespace TsfCorp\Lister\Tests;

use Illuminate\Database\Connection;
use Orchestra\Testbench\TestCase;
use TsfCorp\MysqlLock\MysqlLock;

class MysqlLockTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_that_lock_is_acquired()
    {
        $lock = (new MysqlLock($this->app->make(Connection::class)))->get('lock_1');

        $this->assertTrue($lock);
    }

    public function test_that_lock_is_released()
    {
        // get the lock
        (new MysqlLock($this->app->make(Connection::class)))->get('lock_2');

        // release the lock
        $lock = (new MysqlLock($this->app->make(Connection::class)))->release('lock_2');

        $this->assertTrue($lock);
    }

    public function test_that_lock_is_free()
    {
        $lock = (new MysqlLock($this->app->make(Connection::class)))->isFree('lock_3');

        $this->assertTrue($lock);
    }

    public function test_that_a_lock_can_not_be_acquired_if_already_exits()
    {
        // release the lock
        $lock = (new MysqlLock($this->app->make(Connection::class)))->get('lock_4');

        $this->assertTrue($lock);

        $lock = (new MysqlLock($this->app->make(Connection::class)))->get('lock_4');

        $this->assertFalse($lock);
    }

    public function test_that_a_lock_can_not_be_released_if_not_exists()
    {
        // release the lock
        $lock = (new MysqlLock($this->app->make(Connection::class)))->release('lock_5');

        $this->assertFalse($lock);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'testing',
            'username' => 'ubuntu',
            'password' => 'vagrant',
        ]);
    }
}