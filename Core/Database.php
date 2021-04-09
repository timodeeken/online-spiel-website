<?php

use Core\ConfigManager;


class Database
{
    protected static $connectionHandle;
    public static function GetHandle($db){
        self::$connectionHandle = new \PDO(
            'sqlsrv:Server=' . ConfigManager::GetConfiguration('database.server') .';Database=' .$db,
            ConfigManager::GetConfiguration('database.username'),
            ConfigManager::GetConfiguration('database.password')
        );
        self::$connectionHandle->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return self::$connectionHandle;
    }
}