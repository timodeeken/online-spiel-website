<?php
ini_set('session.cookie_secure', 'On');
session_set_cookie_params(["SameSite" => "Strict"]); //none, lax, strict
session_set_cookie_params(["Secure" => "true"]); //false, true
session_set_cookie_params(["HttpOnly" => "true"]); //false, true
session_start();
require_once('../bootstrap.php');