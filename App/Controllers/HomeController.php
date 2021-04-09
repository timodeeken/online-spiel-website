<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Users;
use BlakeGardner\MacAddress;
use Core\ConfigManager;
use Core\Recaptcha;
use \Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

class HomeController extends Controller
{
    function index()
    {
        echo view('pages/register.twig');
    }

    function Home(){
        echo view('pages/home.twig', ['NewsArray' => Admin::GetNews()]);
    } 
    function imprint(){
        echo view('pages/impressum.twig');
    }

    function login(){
        echo view('pages/login.twig');
    }

    function Accountpanel(){
        $g = new GoogleAuthenticator();
        $secret = 'XVQ2UIGO75XRUKJO';
        if(Controller::IsUser()){
            echo view('pages/accountpanel.twig', [
                'ingameaccounts' => Users::GetIngameAccounts(), 
                'account' => Users::AccountInfo(),
                'key' => $g->generateSecret() . ' - Code ' . $g->getCode($secret),
                'QR' => GoogleQrUrl::generate($_SESSION['username'], $secret, 'Atlantis Flyff')
                ]);
        } else {
            echo view('pages/accountpanel.twig');
        }
       
    }

    function Ticketsystem(){
        echo view('pages/support/ticketsystem/index.twig');
    }

    function Vote(){
        echo view('pages/vote.twig');
    }

    function Ranking(){
        echo view('pages/ranking/ranking.twig', ['users' => Users::UserRanking()]);
    }

    function Support(){
        echo view('pages/support/index.twig');
    }
    function SupportTeam(){
        echo view('pages/support/team.twig');
    }

    function Shop(){
        echo view('pages/shop/index.twig');
    }

    function faq(){
        echo view('pages/support/faq.twig', ['faqs' => Admin::GetFAQ()]);
    }

    function Downloads(){
        echo view('pages/downloads.twig', ['downloads' => Admin::GetDownloads()]);
    }

    public static function MAC(){
        return '';
    }

    function TicketsystemAdd(){
        echo view('pages/support/ticketsystem/new.twig');
    }

    function DiscordWebhook(){
        $url = ConfigManager::GetConfiguration('website.discord');
        $timestamp = date("c", strtotime("now"));
        foreach(Admin::GetNewsWebHook() as $news){
            $headers = [ 'Content-Type: application/json; charset=utf-8' ];
            $POST = [ 
                'username' => 'News', 
                'content' => $news['news_text'],
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
            $response   = curl_exec($ch);


            Admin::UpdateWebHookNews($news['id']);
            
        }
        print '<script type="text/javascript">self.close();</script>';
        
    }
    
    public static function ReadNews($uuid){
        echo view('pages/news/read.twig', ['newsArray' => Users::GetNewsByUUID($uuid)]);
    }
}