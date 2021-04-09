<?php

namespace App\Models;

use App\Controllers\Controller;
use Core\ConfigManager;
use Database;

class Users extends Model
{

    private static $loginDatabase = '[usp_WebLogin]';

    public static function GetTodayAccounts(){
        $account = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('SELECT * FROM WEB_ACC WHERE create_date >= GETDATE()-1');
        $account->execute();
        return count($account->fetchAll());
    }

    public static function GetTodayIngameAccounts(){
        $account = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('SELECT * FROM WEB_ACC_INGAME WHERE create_date >= GETDATE()-1');
        $account->execute();
        return count($account->fetchAll());
    }

    public static function GetAccountsWithAuth(){
        $auths = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT account, uuid, auth FROM WEB_ACC WHERE auth != \'F\''); 
        $auths->execute();
        return $auths->fetchAll();
    }

    public static function CheckAccount($username){
        $account = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('SELECT account FROM WEB_ACC WHERE account = :account'); 
        $account->bindValue(':account', $username); 
        $account->execute();
        return count($account->fetchAll()) > 0;
    }

    public static function CheckIngameAccount($username){
        $account = Database::GetHandle(ConfigManager::GetConfiguration('database.account_dbf'))
                    ->prepare('SELECT account FROM ACCOUNT_TBL WHERE account = :account'); 
        $account->bindValue(':account', $username); 
        $account->execute();
        return count($account->fetchAll()) > 0;
    }


    public static function Login($data = []){
        $login = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
            ->prepare('EXEC ' . self::$loginDatabase . ' @account= :account, @password= :password, @remoteip=:ip');
        $login->bindValue('account', $data['username']);
        $login->bindValue('password', $data['password']); 
        $login->bindValue('ip', $_SERVER['REMOTE_ADDR']);
        $login->execute(); 
        return $login->fetchAll()[0]['retval'];
    }

    public static function GetAuth($account){
        $auth = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT auth FROM WEB_ACC WHERE account=:account'); 
        $auth->bindValue(':account', $account); 
        $auth->execute();
        return $auth->fetch()['auth'];
    }

    private static function GetEMail($account){
        $mail = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT mail FROM WEB_ACC WHERE account = :account');
        $mail->bindValue(':account', $account);
        $mail->execute();
        return $mail->fetch()['mail'];
    }

    public static function AccountInfo(){
        $account = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM WEB_ACC WHERE account = :account');
        $account->bindValue(':account', $_SESSION['username']);
        $account->execute();
        return $account->fetchAll();
    }

    public static function GetIngameAccounts(){
        $ingame = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM WEB_ACC_INGAME WHERE uuid = :uuid');
        $ingame->bindValue(':uuid', self::GetUUID());
        $ingame->execute();
        return $ingame->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function RegisterIngameAccount($data = []){
        $return = 0;
        $webaccount = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('EXEC [usp_CreateIngameAccount] @uuid = :uuid, @account = :account, @create_date = :create_date');
        $webaccount->bindValue('uuid', self::GetUUID());
        $webaccount->bindValue('account', $data['username']);
        $webaccount->bindValue(':create_date', date('Y-m-d\TH:i:s'));
        $result = $webaccount->execute();
        if($result){
            $account = Database::GetHandle(ConfigManager::GetConfiguration('database.account_dbf'))
                    ->prepare('EXEC [usp_CreateNewAccount] @account=:account, @pw=:password, @email=:email');
            $account->bindValue('account', $data['username']);
            $account->bindValue('password', $data['password']);
            $account->bindValue('email', self::GetEMail($_SESSION['username']));
            $result = $account->execute();
            if($result){
                $return = 1;
            } else {
                $return = 2;
            }
        } else {
            $return = 3;
        }
        return $return;
    }

    public static function Register($data = []){
        $userid = uniqid();
        $date = date('Y-m-d');
            $register = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                     ->prepare('EXEC [usp_CreateNewAccount] @account=:account, @pw=:password, @nickname=:nickname, @email=:email, @question=:question, @answer=:answer, @birthday=:birthday, @uuid=:uuid');
            $register->bindValue(':account', $data['username']);
            $register->bindValue(':password', $data['password']);
            $register->bindValue(':nickname', $data['nickname']);
            $register->bindValue(':email', $data['email']);
            $register->bindValue(':question', $data['question']);
            $register->bindValue(':answer', $data['answer']);
            $register->bindValue(':birthday', $data['birthday']);
            $register->bindValue(':uuid', $userid);
            $result = $register->execute();

            if($result){
                return true;
            }
            return false;
    }

    public static function UserRanking(){
        $user = Database::GetHandle(ConfigManager::GetConfiguration('database.character_dbf'))
                ->prepare('SELECT TOP 100 m_szName, m_dwSex, m_nJob, m_nLevel, TotalPlayTime, CreateTime, MultiServer FROM CHARACTER_TBL WHERE [m_chAuthority] = \'F\' AND [isblock] != \'D\' ORDER BY m_nLevel DESC, TotalPlayTime DESC');
        $user->execute(); 
        return $user->fetchAll();
    }


    public static function GetAccount($char){
        $check = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                 ->prepare('SELECT * FROM WEB_ACC_INGAME WHERE uuid = :uuid AND account = :account'); 
        $check->bindValue(':uuid', self::GetUUID()); 
        $check->bindValue(':account', $char);
        $check->execute(); 

        return count($check->fetchAll()) > 0;
    }

    public static function GetCharsbyAccount($account){
        $accounts = Database::GetHandle(ConfigManager::GetConfiguration('database.character_dbf'))
                   ->prepare('SELECT * FROM CHARACTER_TBL WHERE account = :account'); 
        $accounts->bindValue(':account', $account); 
        $accounts->execute(); 

        return $accounts->fetchAll();
    }

    public static function GetNewsByUUID($uuid){
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM NEWS WHERE news_uuid=:uuid'); 
        $news->bindValue(':uuid', $uuid); 
        $news->execute(); 
        return $news->fetchAll();
    }
}