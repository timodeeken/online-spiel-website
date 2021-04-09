<?php 

namespace App\Models;

use Core\ConfigManager;
use Database;

class Admin extends Model {

    private static $NewsUSP = 'usp_add_news';
    private static $Downloadusp = 'usp_add_downloads';
    private static $usp_faq = 'usp_add_faq';

    public static function AddNews($data = []){
        
        $uuid = uniqid();
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('EXEC ' . self::$NewsUSP . ' @news_title= :news_title, @news_text= :news_text, @news_uuid =:news_uuid, @author=:author, @create_date=:create_date, @category=:category, @webhook=:webhook'); 

        $news->bindValue('news_title', $data['news_title']); 
        $news->bindValue('news_text', $data['news_text']); 
        $news->bindValue('news_uuid', $uuid);
        $news->bindValue('author', $_SESSION['username']); 
        $news->bindValue('create_date', date('Y-m-d\TH:i:s')); 
        $news->bindValue('category', $data['category']); 
        $news->bindValue('webhook', $data['discord']);
        $news->execute(); 

        if($news){
            return true;
        }
        return false;
    }

    public static function AddDownloads($data = []){
        $uuid = uniqid();
        $downloads = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('EXEC ' . self::$Downloadusp . ' @download_title= :download_title, @download_link= :download_link, @download_size =:download_size, @download_host=:download_host,@download_uuid=:download_uuid, @create_date=:create_date'); 
        $downloads->bindValue('download_title', $data['download_title']); 
        $downloads->bindValue('download_link', $data['download_link']); 
        $downloads->bindValue('download_size', $data['download_size']);
        $downloads->bindValue('download_host', $data['download_host']); 
        $downloads->bindValue('download_uuid', $uuid); 
        $downloads->bindValue('create_date', date('Y-m-d\TH:i:s')); 
        $downloads->execute(); 

        if($downloads){
            return true;
        }
        return false;
    }

    public static function AddFAQ($data = []){
        $uuid = uniqid();
        $faq = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('EXEC ' . self::$usp_faq . ' @faq_question=:faq_question, @faq_answer=:faq_answer, @author=:author, @faq_uuid=:faq_uuid, @create_date=:create_date'); 
        $faq->bindValue('faq_question', $data['faq_question']); 
        $faq->bindValue('faq_answer', $data['faq_answer']); 
        $faq->bindValue('author', $_SESSION['username']);
        $faq->bindValue('faq_uuid', $uuid); 
        $faq->bindValue('create_date', date('Y-m-d\TH:i:s')); 
        $faq->execute(); 

        if($faq){
            return true;
        }
        return false;
    }

    public static function GetFAQ(){
        $faq = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM FAQ ORDER BY create_date DESC'); 
        $faq->execute(); 

        return $faq->fetchAll();
    }

    public static function deleteFAQ($uuid){
        $faq = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('DELETE FROM FAQ WHERE faq_uuid = \''. $uuid .'\''); 
        $faq->execute();
        if($faq){
            return true;
        } 
        return false;
    }

    public static function deleteNews($uuid){
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('DELETE FROM NEWS WHERE news_uuid = \''. $uuid .'\''); 
        $news->execute();
        if($news){
            return true;
        } 
        return false;
    }


    public static function GetItems(){
        $items = Database::GetHandle(ConfigManager::GetConfiguration('database.item_dbf'))
                ->prepare('SELECT * FROM ITEM_TBL');
        $items->execute(); 
        return $items->fetchAll();
    }



    public static function GetNews(){
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM NEWS ORDER BY create_date DESC'); 

        $news->execute(); 
        return $news->fetchAll(); 
    }

    public static function GetNewsWebHook(){
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM NEWS WHERE webhook = 0'); 

        $news->execute(); 
        return $news->fetchAll();
    }

    public static function UpdateWebHookNews($id){
        $news = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('UPDATE NEWS set webhook = 1 WHERE id='. $id); 

        $news->execute(); 
    }


    public static function GetDownloads(){
        $downloads = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                ->prepare('SELECT * FROM DOWNLOADS ORDER BY create_date DESC'); 

        $downloads->execute(); 
        return $downloads->fetchAll(); 
    }


}