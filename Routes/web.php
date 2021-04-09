<?php

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\TicketController;
use App\Controllers\UsersController;

$routes->get('/register', 'HomeController@index');
$routes->get('/accountpanel', 'HomeController@Accountpanel');
$routes->get('/login', 'HomeController@login');
$routes->get('/logout', 'UsersController@Logout');
$routes->get('/vote', 'HomeController@Vote');
$routes->get('/imprint', 'HomeController@imprint');
$routes->get('/ranking', 'HomeController@Ranking');
$routes->get('/downloads', 'HomeController@Downloads');
$routes->get('/', 'HomeController@Home');
$routes->get('/support', 'HomeController@Support');
$routes->get('/support/team', 'HomeController@SupportTeam');
$routes->get('/support/ticketsystem', 'TicketController@GetTickets');
$routes->get('/shop', 'HomeController@Shop');
$routes->get('/support/faq', 'HomeController@faq');
$routes->get('/api/discord/webhook', 'HomeController@DiscordWebhook');
$routes->get('/support/ticketsystem/add', 'HomeController@TicketsystemAdd');
$routes->get('/news/read', function($uuid){
    HomeController::ReadNews($uuid);
});
$routes->get('/support/ticketsystem/answer', function($uuid){
    TicketController::AnswerTicket($uuid);
});
$routes->get('/ingame', function($char){
    UsersController::GetPlayerByAccount($char);
});
// Administration
$routes->get('/panel', 'AdminController@index');
$routes->get('/panel/api-config', 'AdminController@APIConfig');
$routes->get('/panel/news', 'AdminController@News');
$routes->get('/panel/downloads', 'AdminController@Downloads');
$routes->get('/panel/faq', 'AdminController@faq');
$routes->get('/panel/shop', 'AdminController@shop');
$routes->get('/panel/character', 'AdminController@character');
$routes->get('/panel/gamemaster', 'AdminController@gamemaster');
$routes->get('/panel/faq/delete', function($faq_uuid){
    AdminController::DeleteFAQ($faq_uuid);
});
$routes->get('/panel/news/delete', function($news_uuid) {
    //echo $news_uuid;
    AdminController::DeleteNews($news_uuid);
});
$routes->post('/panel/character', 'AdminController@CharSearch');
$routes->post('/panel/gamemaster', 'AdminController@GamemasterSearch');
$routes->post('/panel/api-config', 'AdminController@UpdateConfig');
$routes->post('/panel/news', 'AdminController@AddNews');
$routes->post('/panel/downloads', 'AdminController@AddDownloads');
$routes->post('/panel/faq', 'AdminController@AddFAQ');

// POST 
$routes->post('/', 'UsersController@SendRegister');
$routes->post('/login', 'UsersController@Login');
$routes->post('/accountpanel', 'UsersController@IngameAccount');
$routes->post('/api/pingback', 'VoteController@index');
$routes->post('/support/ticketsystem/add', 'TicketController@Add');
$routes->notFound(function () {
    echo view('pages/404.twig');
});