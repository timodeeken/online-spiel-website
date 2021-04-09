<?php 

namespace App\Models;

use Core\ConfigManager;
use Database;

class Charcater extends Model{



    public static function Search($data = []){
        $search = Database::GetHandle(ConfigManager::GetConfiguration('database.character_dbf'))
                    ->prepare('SELECT * FROM CHARACTER_TBL WHERE m_szName = :m_szName');
        $search->bindValue('m_szName', $data['charactersearch']);
        $search->execute(); 
        return $search->fetchAll();
    }

    public static function ItemLogs($data = []){
        $item = Database::GetHandle(ConfigManager::GetConfiguration('database.logging_dbf'))
                ->prepare('SELECT m_szName, m_GetszName, Item_UniqueNo, Item_Name, Item_count FROM LOG_ITEM_TBL WHERE m_szName =:m_szName AND m_GetszName = :m_GetszName ORDER BY s_date DESC');
        $item->bindValue('m_szName', 'GROUND');
        $item->bindValue('m_GetszName', $data['charactersearch']);
        $item->execute();
        return $item->fetchAll();
    }

    public static function Logins($data){
        $login = Database::GetHandle(ConfigManager::GetConfiguration('database.logging_dbf'))
                    ->prepare('SELECT dwWorldID, Start_Time, End_Time, remoteIP, account, CharLevel, Job FROM LOG_LOGIN_TBL WHERE m_idPlayer =:m_idPlayer'); 
        $login->bindValue('m_idPlayer', $data); 
        $login->execute();
        return $login->fetchAll();
    }

    public static function Levelups($data){
        $levelups = Database::GetHandle(ConfigManager::GetConfiguration('database.logging_dbf'))
                    ->prepare('SELECT m_nLevel, m_nJob, m_nStr, m_nSta, m_nDex, m_nInt, m_dwGold, TotalPlayTime, s_date FROM LOG_LEVELUP_TBL WHERE m_idPlayer =:m_idPlayer ORDER BY m_nLevel ASC');
        $levelups->bindValue('m_idPlayer', $data); 
        $levelups->execute(); 
        return $levelups->fetchAll();            
    }


    public static function Commands($data){
        $commands = Database::GetHandle(ConfigManager::GetConfiguration('database.logging_dbf'))
                    ->prepare('SELECT m_szWords, s_date FROM LOG_GAMEMASTER_TBL WHERE m_idPlayer = :m_idPlayer'); 

        $commands->bindValue('m_idPlayer', $data); 
        $commands->execute(); 
        return $commands->fetchAll();
    }

    public static function CheckCharacter($name = []){
        $char = Database::GetHandle(ConfigManager::GetConfiguration('database.character_dbf'))
                ->prepare('SELECT m_idPlayer FROM CHARACTER_TBL WHERE m_szName =:m_szName');
        $char->bindValue('m_szName', $name['charactersearch']); 
        $char->execute();
        return count($char->fetchAll()) > 0;
    }

    public static function Inventory($data){
        $inventory = Database::GetHandle(ConfigManager::GetConfiguration('database.character_dbf'))
                        ->prepare('SELECT m_Inventory, m_apIndex FROM INVENTORY_TBL WHERE m_idPlayer = :m_idPlayer'); 
        $inventory->bindValue('m_idPlayer', $data); 
        $inventory->execute(); 
        $inventoryItems = $inventory->fetch();

        $m_inventory = explode('/', $inventoryItems['m_Inventory']); 
        $m_index[] = explode('/', $inventoryItems['m_apIndex']); 
        $m_Inventory_detail = [];
        for($i = 0; $i < count($m_inventory); $i++) {

            $arr = explode(',', $m_inventory[$i]);

            if($arr[0] != '$') {
                $m_Inventory_detail[$i] = [
                    'm_dwObjId' => $arr[0],
                    'm_dwItemId' => $arr[1],
                    'bEquip' => $arr[2],
                    'nTrade' => $arr[3],
                    'm_szItemText' => $arr[4],
                    'm_nItemNum' => $arr[5],
                    'm_nRepairNumber' => $arr[6],
                    'm_nHitPoint' => $arr[7],
                    'nMaxHitPoint' => $arr[8],
                    'nMaterial' => $arr[9],
                    'm_byFlag' => $arr[10],
                    'm_liSerialNumber' => $arr[11],
                    'm_nAbilityOption' => $arr[12]
                ];

                $slot[$i] = array_search($arr[0], $m_index[0]);
            }
        }
        return $m_Inventory_detail;
    }

}