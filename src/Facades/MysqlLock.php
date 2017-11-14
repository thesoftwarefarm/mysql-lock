<?php

namespace TsfCorp\MysqlLock\Facades;

use Illuminate\Support\Facades\Facade;

class MysqlLock extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mysqllock';
    }
}