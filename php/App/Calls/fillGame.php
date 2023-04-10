<?php

use Exception;
use App\Model\Ticket;

include_once("../Model/Ticket.php");
include_once("../Model/Database.php");

/**
 * FillGame - Remplissage de la partie à partir du schéma des tickets de la BDD.
 *
 */
$ticket = new Ticket();
$ticketData = $ticket::getTicketById(1);
