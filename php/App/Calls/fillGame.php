<?php

use App\Model\GameManager;
use Exception;

include_once("../Model/Ticket.php");
include_once("../Model/Database.php");

/**
 * FillGame - Remplissage de la partie à partir du schéma des tickets de la BDD.
 *
 */
$gameManager = new GameManager();
$ticket = $gameManager::getTicketById(1);
