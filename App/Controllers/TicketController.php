<?php 

namespace App\Controllers;

use App\Models\Ticket;

class TicketController extends Controller {


    function Add(){
        if($this->IsPost()){
            if(Ticket::AddTicket($_POST, $_FILES)){
                $this->Redirect('/support/ticketsystem', false);
            }
        }
    }

    public static function AnswerTicket($uuid){
        echo view('pages/support/ticketsystem/answer.twig', ['answers' => Ticket::GetTicketAnswer($uuid)]);
    }


    function GetTickets(){
        echo view('pages/support/ticketsystem/index.twig', ['tickets' => Ticket::GetTickets()]);
    }



}