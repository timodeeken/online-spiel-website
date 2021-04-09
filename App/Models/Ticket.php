<?php 

namespace App\Models;

use Core\ConfigManager;
use Database;

class Ticket extends Model {


    private static $ticket_add_usp = 'usp_ticket_add'; 


    public static function AddTicket($data = [], $files = []){
        $uuid = uniqid();
        $ticket = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('EXEC ' . self::$ticket_add_usp . ' @ticket_title= :ticket_title, @ticket_text= :ticket_text, @ticket_category=:ticket_category, @ticket_user=:ticket_user, @ticket_uuid=:ticket_uuid, @ticket_attachment=:ticket_attachment, @ticket_date=:ticket_date');
        $ticket->bindValue('ticket_title', $data['ticket_title']); 
        $ticket->bindValue('ticket_text', nl2br($data['ticket_text'])); 
        $ticket->bindValue('ticket_category', $data['ticket_category']); 
        $ticket->bindValue('ticket_user', self::GetUUID()); 
        $ticket->bindValue('ticket_uuid', $uuid); 
        $ticket->bindValue('ticket_attachment', $files['ticket_attachment']['name']); 
        $ticket->bindValue('ticket_date', date('Y-m-d\TH:i:s')); 

        $ticket->execute(); 

        if($ticket){
            return true;
        }
        return false;
        
    }


    public static function GetTickets(){
        $user = self::GetUUID();
        $ticket = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('SELECT * FROM TICKETSYSTEM WHERE ticket_user = \''. $user .'\'');
        $ticket->execute(); 
        return $ticket->fetchAll();
    }

    public static function GetTicketAnswer($uuid){
        $ticket = Database::GetHandle(ConfigManager::GetConfiguration('database.website_dbf'))
                    ->prepare('SELECT * FROM TICKETSYSTEM WHERE ticket_uuid = \''. $uuid .'\'');
        $ticket->execute(); 
        return $ticket->fetchAll();
    }




}