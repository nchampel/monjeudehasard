<?php

namespace App\Controller;

use Exception;
use App\Model\Ticket;

// include_once("App/Model/Ticket.php");
// include_once("App/Model/Database.php");

/**
 * FillGame - Remplissage de la partie à partir du schéma des tickets de la BDD.
 *
 */
class Test
{
    public function test()
    {
        $ticket = new Ticket();
        $ticketData = $ticket::getTicketById(1);
    }
}
