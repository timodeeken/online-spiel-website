<?php

namespace App\Controllers;

use App\Models\Users;
use Core\NotificationManager;
use Core\Recaptcha;
use \Sonata\GoogleAuthenticator\GoogleAuthenticator; 

class UsersController extends Controller
{


    

    public static function Username(){
        if(self::IsUser()){
            return $_SESSION['username'];
        } 
        return '';
    }
    public static function CanSeeAdminPanel(){
        return Controller::IsAdmin();
    }

    private static function RegisterSession($data = []){
        if(!empty($data['username'])){
            $_SESSION['username'] = $data['username'];
            return true;
        }
        return false;
    }


    function Logout(){
        if(session_destroy()){
            $this->Redirect('/', false);
        }
    }

    function Login(){
        if($this->IsPost()){
            if($this->SQLInject($_SERVER['HTTP_USER_AGENT']) === 0){
                if(Recaptcha::validateRequest($_POST['recaptcha_response_login'], $_SERVER['REMOTE_ADDR'])){
                    if(Users::Login([
                        'username' => $this->Clear($_POST['username']), 
                        'password' => $this->Crypt($this->Clear($_POST['password']))
                        ]) == 1){
                            if(self::RegisterSession([
                                'username' => $this->Clear($_POST['username']),
                                'auth' => Users::GetAuth($this->Clear($_POST['username']))
                            ])){
                                $this->Redirect('/accountpanel', false);
                            } 
                        } else if (Users::Login([
                            'username' => $this->Clear($_POST['username']), 
                            'password' => $this->Clear($this->Crypt($_POST['password']))
                        ]) == 0){
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_FAILURE, 
                                'Account and password do not match.'
                            );
                            echo view('pages/home.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                        } else {
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_FAILURE, 
                                'Unfortunately, your login has been blocked for the time being'
                            );
                            echo view('pages/home.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                        }
                } else {
                    NotificationManager::ShowTemporaryNotification(
                        NotificationManager::TYPE_FAILURE, 
                        'Unfortunately, security token does not match. try again'
                    );
                    echo view('pages/home.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                }
            } else {
                NotificationManager::ShowTemporaryNotification(
                    NotificationManager::TYPE_FAILURE, 
                    'A change in the browser was detected.'
                );
                echo view('pages/home.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
            }
        } else {
            NotificationManager::ShowTemporaryNotification(
                NotificationManager::TYPE_FAILURE, 
                'Unfortunately a form error occurred. try again'
            );
            echo view('pages/home.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
        }
    }

    function SendRegister(){
        if($this->IsPost()){
            if(Recaptcha::validateRequest($_POST['recaptcha_response'], $_SERVER['REMOTE_ADDR'])){
                if($this->SQLInject($_SERVER['HTTP_USER_AGENT']) === 0){
                    if(!Users::CheckAccount($this->Clear($_POST['username']))){
                        if(!empty($_POST['username']) && !empty($_POST['password'])){
                            if($_POST['password'] == $_POST['password_repeat']){
                                if($_POST['email'] == $_POST['email_repeat']){
                                    if(Users::Register([
                                        'username' => $this->Clear($_POST['username']),
                                        'password' => $this->Crypt($this->Clear($_POST['password'])),
                                        'nickname' => $this->Clear($_POST['nickname']),
                                        'email' => $_POST['email'],
                                        'question' => $_POST['question'],
                                        'answer' => $this->Clear($_POST['answer']),
                                        'birthday' => $_POST['birthday']
                                    ])){
                                        NotificationManager::ShowTemporaryNotification(
                                            NotificationManager::TYPE_SUCCESS, 
                                            'Account has been created. You can now log in to create an ingame account'
                                        );
                                        echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                                    }
                                } else {
                                    NotificationManager::ShowTemporaryNotification(
                                        NotificationManager::TYPE_FAILURE, 
                                        'e mails do not match'
                                    );
                                    echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                                }
                            } else {
                                NotificationManager::ShowTemporaryNotification(
                                    NotificationManager::TYPE_FAILURE, 
                                    'Passwords do not match'
                                );
                                echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                            }
                        } else {
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_FAILURE, 
                                'Account and or password are unfortunately empty'
                            );
                            echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                        }
                    } else {
                        NotificationManager::ShowTemporaryNotification(
                            NotificationManager::TYPE_FAILURE, 
                            'Account already in use!'
                        );
                        echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                    } 
                } else {
                    NotificationManager::ShowTemporaryNotification(
                        NotificationManager::TYPE_FAILURE, 
                        'A change in the browser was detected.'
                    );
                    echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
                }
            } else {
                NotificationManager::ShowTemporaryNotification(
                    NotificationManager::TYPE_FAILURE, 
                    'Unfortunately, security token does not match. try again'
                );
                echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
            }
        } else {
            NotificationManager::ShowTemporaryNotification(
                NotificationManager::TYPE_FAILURE, 
                'Unfortunately a form error occurred. try again'
            );
            echo view('pages/register.twig', ['notifications' => NotificationManager::GetTemporaryNotifications()]);
        }
    }

   
    function IngameAccount(){
        if($this->IsPost()){
            if(Recaptcha::validateRequest($_POST['recaptcha_response'], $_SERVER['REMOTE_ADDR'])){
                if($this->SQLInject($_SERVER['HTTP_USER_AGENT']) === 0){
                    if(!Users::CheckIngameAccount($this->Clear($_POST['username']))){
                        $register = Users::RegisterIngameAccount([
                            'username' => $this->Clear($_POST['username']),
                            'password' => $this->CryptNormal($this->Clear($_POST['password']))
                        ]);
                        if($register === 1){
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_SUCCESS, 
                                'Account has been created. You can now log in to the Game.'
                            );
                            echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
                        } else if($register === 2){
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_FAILURE, 
                                'Unfortunately a form error occurred. try again'
                            );
                            echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
                        } else {
                            NotificationManager::ShowTemporaryNotification(
                                NotificationManager::TYPE_FAILURE, 
                                'Unfortunately a form error occurred. try again'
                            );
                            echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
                        }
                    } else {
                        NotificationManager::ShowTemporaryNotification(
                            NotificationManager::TYPE_FAILURE, 
                            'Account already in use!'
                        );
                        echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
                    }
                } else {
                    NotificationManager::ShowTemporaryNotification(
                        NotificationManager::TYPE_FAILURE, 
                        'A change in the browser was detected.'
                    );
                    echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
                }
            } else {
                NotificationManager::ShowTemporaryNotification(
                    NotificationManager::TYPE_FAILURE, 
                    'Unfortunately, security token does not match. try again'
                );
                echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
            }
        } else {
            NotificationManager::ShowTemporaryNotification(
                NotificationManager::TYPE_FAILURE, 
                'Unfortunately a form error occurred. try again'
            );
            echo view('pages/accountpanel.twig', ['notifications' => NotificationManager::GetTemporaryNotifications(), 'account' => Users::AccountInfo(),'ingameaccounts' => Users::GetIngameAccounts()]);
        }
    }

    public static function GetPlayerByAccount($char){
        if(Users::GetAccount($char)){
            echo view('pages/player.twig', ['array' => Users::GetCharsbyAccount($char)]);
        }
    }
}