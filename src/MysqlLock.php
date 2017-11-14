<?php

namespace TsfCorp\MysqlLock;

use Illuminate\Database\Connection;

class MysqlLock
{
    /**
     * @var Connection
     */
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Tries to obtain a free lock
     *
     * Returns TRUE if the lock was acquired successfully, FALSE otherwise.
     *
     * @param $lock_name
     * @return bool
     */
    public function get($lock_name)
    {
        return $this->isFree($lock_name) && $this->acquire($lock_name);
    }

    /**
     * Releases the lock with the specified name.
     *
     * Returns TRUE if the operation succeeded AND if a lock with the specified name did not exist. FALSE otherwise.
     *
     * @param $lock_name
     * @return bool
     */
    public function release($lock_name)
    {
        if(empty($lock_name)) return false;

        $result = $this->db->select( $this->db->raw("SELECT RELEASE_LOCK('{$lock_name}') AS status") );

        return isset($result[0]->status) && ( $result[0]->status == 1 || is_null($result[0]->status) );
    }

    /**
     * Tries to obtain a lock with the specified name.
     *
     * Returns TRUE if the lock was acquired successfully, FALSE otherwise.
     *
     * @param $lock_name
     * @return bool
     */
    private function acquire($lock_name)
    {
        if(empty($lock_name)) return false;

        $timeout = 1; // seconds

        $result = $this->db->select( $this->db->raw("SELECT GET_LOCK('{$lock_name}', {$timeout}) AS status") );

        return isset($result[0]->status) && $result[0]->status == 1;
    }

    /**
     * Checks if the lock with the specified name is free to use.
     *
     * Returns TRUE if the lock is free (no one is using the lock), FALSE otherwise.
     *
     * @param $lock_name
     * @return bool
     */
    public function isFree($lock_name)
    {
        if(empty($lock_name)) return false;

        $result = $this->db->select( $this->db->raw("SELECT IS_FREE_LOCK('{$lock_name}') AS status") );

        return isset($result[0]->status) && $result[0]->status == 1;
    }
}