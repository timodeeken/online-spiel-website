<?php

namespace App\Controllers;

use App\Models\Item;
use App\Models\Users;
use Core\ConfigManager;

abstract class Controller
{

    public function IsPost(){
        if(isset($_POST)){
            return true;
        } 
        return false;
    }

    function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    public function Crypt($string){
        return sha1(ConfigManager::GetConfiguration('server.salt') . $string);
    } 

    public function Clear($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }


    public function before()
    {
        // method called before controller execution
    }

    public function after()
    {
        // method called at the end of controller execution
    }

    public function __destruct()
    {
        $this->after();
    }

    public static function IsUser(){
        if(isset($_SESSION['username'])){
            return true;
        } 
        return false;
    }

    function SQLInject($data) {                   
        $badchars = ['DROP', 'DELETE', 'TRUNCATE', 'TABLE', 'UPDATE', 'SELECT', 'INSERT']; 
        foreach ($badchars as $key => $value) {           
            if (strpos(strtoupper($data), $value, $offset = 0) !== FALSE)  { 
                $detection = $value; 
            }  
            else { 
                $detection = 0; 
            } 
        }       
        return $detection;                   
    }  

    public static function IsAdmin(){
        if(self::IsUser()){
            $auth = Users::GetAuth($_SESSION['username']);
            if(!empty($_SESSION['username']) ){
                if(sha1($auth) == sha1(ConfigManager::GetConfiguration('security.admin'))){
                    return true;
                } else if(sha1($auth) == sha1(ConfigManager::GetConfiguration('security.gamemaster'))){
                    return true;
                } 
                return false;
            } 
            return false;
        }
        return false;
    }

    public static function Hosts($id){
        switch($id){
            case 1: 
                return 'Mega.nz';
                break;
            case 2: 
                return 'Localhost';
                break;
            case 3: 
                return 'Google Drive';
                break;
            case 4: 
                return 'file-upload.net';
                break;
        }
    }

    public static function IsOnlyAdmin(){
        if(self::IsUser()){
            $auth = Users::GetAuth($_SESSION['username']);
            if(!empty($_SESSION['username'])){
                if( sha1($auth) == sha1(ConfigManager::GetConfiguration('security.admin'))){
                    return true;
                }
                return false;
            } 
            return false;
        }
        return false;
    }

    public static function Sidebar($key){
        return ConfigManager::GetConfiguration('website.rates.' . $key);
    }


    public static function IsOnlyGamemaster(){
        if(self::IsUser()){
            $auth = Users::GetAuth($_SESSION['username']);
            if(!empty($_SESSION['username'])){
                if(sha1($auth) == sha1(ConfigManager::GetConfiguration('security.gamemaster'))){
                    return true;
                }
                return false;
            } 
            return false;
        }
        return false;
    }

    function sha512($str) {
        $str = hash('sha512', ConfigManager::GetConfiguration('server.salt') . $str);
        return $str;
    }

    public static function ItemName($id){
        if(isset($id)){
            return Item::ItemnameByID($id);
        }
        return '';
    }

    public static function FlyffTime($time){
        return strtotime($time);
    }
    public static function RenderIcon($id){
        $icon = Item::IconById($id); 
        $png = str_replace('.dds', '.png', $icon); 
        return $png;
    }

    function CryptNormal($string){
        return md5(ConfigManager::GetConfiguration('server.salt') . $string);
    }
    public static function PlayTime($seconds){
        $Stunden = floor($seconds / 3600); $Rest1 = (($seconds / 3600) - $Stunden); 
        $Minuten = floor($Rest1 * 60);
		return $Stunden.'h '.$Minuten.'m';
    }

    

}