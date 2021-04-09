<?php 

namespace App\Models;

use Core\ConfigManager;
use Database;

class Item extends Model{


    public static function ItemnameByID($id){
        $item = Database::GetHandle(ConfigManager::GetConfiguration('database.item_dbf'))
                ->prepare('SELECT szName FROM ITEM_TBL WHERE [Index] = \''. $id .'\''); 
        $item->execute(); 
        return $item->fetch()['szName'];
    }

    public static function IconById($id){
        $icon = Database::GetHandle(ConfigManager::GetConfiguration('database.item_dbf'))
                ->prepare('SELECT szIcon FROM ITEM_TBL WHERE [Index] =:index'); 
        $icon->bindValue('index', $id); 
        $icon->execute(); 
        return $icon->fetch()['szIcon'];
    }

}