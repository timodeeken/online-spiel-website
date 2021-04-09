<?php

namespace App\Models;

use Core\ConfigManager;
use Database;

abstract class Model
{
    function UUID(){
        return uniqid();
    }


    public static function GetUUID(){
        $uuid = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT uuid FROM WEB_ACC WHERE account = :account');
        $uuid->bindValue(':account', $_SESSION['username']);
        $uuid->execute();
        return $uuid->fetch()['uuid'];
    }

    public static function Peak(){
        $sth = Database::GetHandle(ConfigManager::GetConfiguration('database.logging_dbf'))
                ->prepare("SELECT TOP 1 number FROM LOG_USER_CNT_TBL ORDER BY number DESC");
        return $sth->fetch()['number'];
    }
}