<?php 

namespace Core;
use Core\ConfigManager; 

class Recaptcha {
    public static function validateRequest($gRecaptchaResponse, $remoteIp)
    {
        $post_data = http_build_query(array(
            'secret' => ConfigManager::GetConfiguration('website.privatekey'),
            'response' => $gRecaptchaResponse,
            'remoteip' => $remoteIp
        ));
        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $post_data
        ));
        $context = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);
        if (!$result->success) {
            return false;
        } else {
            return true;
        }
    }

}