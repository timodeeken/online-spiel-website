<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Charcater;
use App\Models\Users;
use Core\ConfigManager;

class AdminController extends Controller
{

    function index(){
        echo view('Admin/pages/home.twig', [
            'TdyAcc' => Users::GetTodayAccounts(),
            'TdyInAcc' => Users::GetTodayIngameAccounts(), 
            'AccountsAuth' => Users::GetAccountsWithAuth()
        ]);
    }

    function UpdateConfig(){
        $array = [
            [
                'website' => [
                    'title' => $this->Clear($_POST['title']),
                    'https' => true,
                    'view' => $this->Clear($_POST['view']),
                    'controller' => $this->Clear($_POST['controller']),
                    'routes' => $this->Clear($_POST['routes']),
                    'publickey' => $this->Clear($_POST['publickey']),
                    'privatekey' => $this->Clear($_POST['privatekey']),
                    'discord' => $_POST['discord'],
                    'max_ingame_accounts' => (int)$_POST['max_ingame_accounts'],
                    'rates' => [
                        'exp' => (int)$this->Clear($_POST['exp']),
                        'penya' => (int)$this->Clear($_POST['penya']),
                        'drop' => (int)$this->Clear($_POST['drop'])
                    ], 
                    'sidebar' => [
                        'user_online' => true,
                        'user_peak' => true
                    ]
                ], 
                'database' => [
                    'server' => $this->Clear($_POST['server']),
                    'username' => $this->Clear($_POST['username']),
                    'password' => (string)$_POST['password'],
                    'account_dbf' => $this->Clear($_POST['account_dbf']),
                    'character_dbf' => $this->Clear($_POST['character_dbf']),
                    'logging_dbf' => $this->Clear($_POST['logging_dbf']),
                    'website_dbf' => $this->Clear($_POST['website_dbf']),
                    'item_dbf' => $this->Clear($_POST['item_dbf'])
                ], 
                'server' => [
                    'salt' => $this->Clear($_POST['salt']),
                    'ip' => $this->Clear($_POST['ip']),
                    'port' => $this->Clear($_POST['port'])
                ], 
                'shop' => [
                    'param1' => $this->Clear($_POST['param1']),
                    'param2' => $this->Clear($_POST['param2']),
                    'max_shoppingcard' => (int)$this->Clear($_POST['max_shoppingcard'])
                ], 
                'security' => [
                    'admin' => $this->Clear($_POST['admin']),
                    'gamemaster' => $this->Clear($_POST['gamemaster']),
                    'user' => $this->Clear($_POST['user'])
                ],
                'vote' => [
                    'reward' => (int)$this->Clear($_POST['reward'])
                ]
            ]
        ];
        ConfigManager::EditConfig($array);
        echo view('Admin/pages/api.twig');
    }


    function shop(){
        echo view('Admin/pages/shop/index.twig', ['items' => Admin::GetItems()]);
    }

    function character(){
        echo view('Admin/pages/character/index.twig');
    }

    function CharSearch(){
        if($this->IsPost()){
            if(Charcater::CheckCharacter($_POST)){
                echo view('Admin/pages/character/index.twig', [
                    'character' => Charcater::Search($_POST),
                    //'drops' => Charcater::ItemLogs($_POST),
                    //'logins' => Charcater::Logins(Charcater::Search($_POST)[0]['m_idPlayer']),
                    //'levelups' => Charcater::Levelups(Charcater::Search($_POST)[0]['m_idPlayer']),
                    //'inventory' => Charcater::Inventory(Charcater::Search($_POST)[0]['m_idPlayer'])
                ]);
            } else {
                echo view('Admin/pages/character/index.twig');
            }
        }
    }

    function gamemaster(){
        echo view('Admin/pages/gamemaster/index.twig');
    }

    function GamemasterSearch(){
        if($this->IsPost()){
            if(Charcater::CheckCharacter($_POST)){
                echo view('Admin/pages/gamemaster/index.twig', [
                    'character' => Charcater::Search($_POST),
                    'logins' => Charcater::Logins(Charcater::Search($_POST)[0]['m_idPlayer']),
                    'commands' => Charcater::Commands(Charcater::Search($_POST)[0]['m_idPlayer']),
                    'levelups' => Charcater::Levelups(Charcater::Search($_POST)[0]['m_idPlayer'])
                ]);
            } else {
                echo view('Admin/pages/gamemaster/index.twig');
            }
        }
    }

    function APIConfig(){
        echo view('Admin/pages/api.twig');
    }

    function News(){
        echo view('Admin/pages/news.twig', ['newsArray' => Admin::GetNews()]);
    }

    function Downloads(){
        echo view('Admin/pages/downloads.twig', ['downloads' => Admin::GetDownloads()]);
    }

    function faq(){
        echo view('Admin/pages/faq.twig', ['faqs' => Admin::GetFAQ()]);
    }

    function AddFAQ(){
        if($this->IsPost()){
            if(Admin::AddFAQ($_POST)){
                echo view('Admin/pages/faq.twig', ['faqs' => Admin::GetFAQ()]);
            }
        }
    }

    public static function DeleteFAQ($uuid){
        if(Admin::deleteFAQ($uuid)){
            echo view('Admin/pages/faq.twig', ['faqs' => Admin::GetFAQ()]);
        }
    }

    public static function DeleteNews($uuid){
        if(Admin::deleteNews($uuid)){
            echo view('Admin/pages/news.twig', [
                'newsArray' => Admin::GetNews()
            ]);
        }
    }

    function AddNews(){
        if($this->IsPost()){
            if(isset($_POST['discord'])){
                $discord = 0;
            } else {
                $discord = 1;
            }
            if(Admin::AddNews([
                'news_title' => $_POST['news_title'],
                'news_text' => $_POST['news_text'],
                'category' => $_POST['news_category'],
                'discord' => $discord
            ])){
                if($discord == 0){
                    echo view('Admin/pages/news.twig', [
                        'newsArray' => Admin::GetNews(),
                        'script' => '<script>window.open("https://'. $_SERVER['SERVER_NAME'] .'/api/discord/webhook","popup","width=600,height=600,scrollbars=no,resizable=no");</script>'
                    ]);
                } else {
                    echo view('Admin/pages/news.twig', [
                        'newsArray' => Admin::GetNews()
                    ]);
                }
            }
            
        }
    }

    function AddDownloads(){
        if($this->IsPost()){
            if(Admin::AddDownloads($_POST)){
                echo view('Admin/pages/downloads.twig', ['downloads' => Admin::GetDownloads()]);
            }
        }
    }
}