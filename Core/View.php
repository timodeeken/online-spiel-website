<?php

use App\Controllers\Controller;
use App\Controllers\UsersController;
use App\Models\Model;
use Core\ConfigManager;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
interface IView
{
    public static function init(): void;

    public static function render($file, $vars = []): string;

    public static function addGlobalVar($key, $value): void;
}

class View implements IView
{
    private static $engine = null;

    public static function init(): void
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT . "/" . PATH_VIEWS . "/");
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            //'cache' => ROOT . '/' . 'cache',
        ]);

        
        $twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
            public function load($class) {
                if (MarkdownRuntime::class === $class) {
                    return new MarkdownRuntime(new DefaultMarkdown());
                }
            }
        });
        $twig->addGlobal('SiteKey', ConfigManager::GetConfiguration('website.publickey'));
        $twig->addGlobal('Sitename', ConfigManager::GetConfiguration('website.title'));
        $twig->addGlobal('IsUser', UsersController::IsUser());
        $twig->addGlobal('Username', UsersController::Username());
        $twig->addGlobal('PanelView', UsersController::CanSeeAdminPanel());
        $twig->addGlobal('IsAdmin', UsersController::IsOnlyAdmin());
        $twig->addGlobal('IsGamemaster', UsersController::IsOnlyGamemaster());
        $twig->addGlobal('ServerStatus', self::PingServerChannel(ConfigManager::GetConfiguration('server.port'), ConfigManager::GetConfiguration('server.ip')));
        //$twig->addGlobal('peak', Model::Peak());
        $twig->addFilter(new \Twig\TwigFilter('playtime', function ($seconds) {
            return Controller::PlayTime($seconds);
        }));

        $twig->addFilter(new \Twig\TwigFilter('itemname', function ($id) {
            return Controller::ItemName($id);
        }));

        $twig->addFilter(new \Twig\TwigFilter('icon', function ($id) {
            return Controller::RenderIcon($id);
        }));

        $twig->addFilter(new \Twig\TwigFilter('flyfftime', function ($time) {
            return Controller::FlyffTime($time);
        }));
        $twig->addFilter(new \Twig\TwigFilter('shorthtml', function ($text){
            return substr(strip_tags($text),0,25) . " ...";
        }));
        $twig->addFilter(new \Twig\TwigFilter('OnlineStatus', function ($status) {
            switch($status){
                case 1:
                    return 'Online'; 
                    break; 
                case 0: 
                    return 'Offline'; 
                    break; 
                default: 
                    return ''; 
                    break;
            }
        }));
        $twig->addFilter(new \Twig\TwigFilter('Sidebar', function ($key) {
            return Controller::Sidebar($key);
        }));
        $twig->addFilter(new \Twig\TwigFilter('category', function ($key) {
            switch($key){
                case 1: 
                    return 'News'; 
                    break; 
                case 2: 
                    return 'Patchlog'; 
                    break; 
                case 3: 
                    return 'Events'; 
                    break; 
                default: 
                    return 'News'; 
                    break;
            }
        }));
        $twig->addFilter(new \Twig\TwigFilter('GetConfig', function ($key) {
            return ConfigManager::GetConfiguration($key);
        }));
        $twig->addFilter(new \Twig\TwigFilter('Host', function ($id) {
            return Controller::Hosts($id);
        }));
        $twig->addFilter(new \Twig\TwigFilter('flyff_class_img', function ($job) {
            return '/assets/images/Classes/' . $job . '.png';
        }));
        $twig->addFilter(new \Twig\TwigFilter('auth', function ($auth) {
            switch($auth){
                case ConfigManager::GetConfiguration('security.admin'): 
                    return '<span class="text-danger">Administrator</span>'; 
                    break;
                case ConfigManager::GetConfiguration('security.gamemaster'): 
                    return '<span class="text-success">Gamemaster</span>';
                    break;
                default: 
                    return ''; 
                    break;
            }
        }));
        $twig->addFilter(new \Twig\TwigFilter('flyff_class', function ($job) {
            if ($job == 0) {return "Vagrant";}
            if ($job == 1) {return "Mercenary";}
            if ($job == 2) {return "Acrobat";}
            if ($job == 3) {return "Assist";}
            if ($job == 4) {return "Magician";}
            if ($job == 5) {return "Puppeter";}
            if ($job == 6) {return "Knight";}
            if ($job == 7) {return "Blade";}
            if ($job == 8) {return "Jester";}
            if ($job == 9) {return "Ranger";}
            if ($job == 10) {return "Ringmaster";}
            if ($job == 11) {return "Billposter";}
            if ($job == 12) {return "Psykeeper";}
            if ($job == 13) {return "Elementor";}
            if ($job == 14) {return "Gatekeeper";}
            if ($job == 15) {return "Doppler";}
            if ($job == 16) {return "Master Knight";}
            if ($job == 17) {return "Master Blade";}
            if ($job == 18) {return "Master Jester";}
            if ($job == 19) {return "Master Ranger";}
            if ($job == 20) {return "Master Ringmaster";}
            if ($job == 21) {return "Master Billposter";}
            if ($job == 22) {return "Master Psykeeper";}
            if ($job == 23) {return "Master Elementor";}
            if ($job == 24) {return "Hero Knight";}
            if ($job == 25) {return "Hero Blade";}
            if ($job == 26) {return "Hero Jester";}
            if ($job == 27) {return "Hero Ranger";}
            if ($job == 28) {return "Hero Ringmaster";}
            if ($job == 29) {return "Hero Billposter";}
            if ($job == 30) {return "Hero Psykeeper";}
            if ($job == 31) {return "Hero Elementor";}
            if ($job == 32) {return "Templar";}
            if ($job == 33) {return "Slayer";}
            if ($job == 34) {return "Harlequin";}
            if ($job == 35) {return "Crackshooter";}
            if ($job == 36) {return "Seraph";}
            if ($job == 37) {return "Forcemaster";}
            if ($job == 38) {return "Mentalist";}
            if ($job == 39) {return "Arcanist";}
        }));
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addExtension(new \Twig\Extra\Markdown\MarkdownExtension());
        $twig->addExtension(new \Twig\Extra\String\StringExtension());
        self::$engine = $twig;
    }

    public static function render($file, $vars = []): string
    {
        $template = self::$engine->load($file);
        return $template->render($vars);
    }

    public static function addGlobalVar($key, $value): void
    {
        self::$engine->addGlobal($key, $value);
    }
    

    private static function PingServerChannel($port, $ip){
		if(@fsockopen($ip, $port, $errno, $errstr, 0.45) >= 0.45) {
			return true;
		} 
		else {
			return false;
		}
	}


    public static function rip_tags($string) {
    
        // ----- remove HTML TAGs -----
        $string = preg_replace ('/<[^>]*>/', ' ', $string);
    
        // ----- remove control characters -----
        $string = str_replace("\r", '', $string);    // --- replace with empty space
        $string = str_replace("\n", ' ', $string);   // --- replace with space
        $string = str_replace("\t", ' ', $string);   // --- replace with space
    
        // ----- remove multiple spaces -----
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
    
        return $string;

    }
    
}