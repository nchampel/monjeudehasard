<?php

namespace App\Controller;

use App\Model\GameManager;
use Exception;
use App\Model\Ticket;
use App\Model\TicketModel;

// include_once("App/Model/Ticket.php");
// include_once("App/Model/Database.php");

/**
 * FillGame - Remplissage de la partie à partir du schéma des tickets de la BDD.
 *
 */
class GameController
{
    public function test()
    {
        $gameManager = new GameManager();
        $ticketData = $gameManager::getTicketById(1);
        // print_r($ticketData);
        $ticketHydrated = new Ticket($ticketData);
        print_r($ticketHydrated);
    }

    public function initGame()
    {
        $userId = 1;
        $gameManager = new GameManager();
        $gameId = $gameManager::getGameIdByUserId($userId);
        if (!is_null($gameId['gameId'])) {
            $newGameId = $gameId['gameId'] + 1;
        } else {
            $newGameId = 1;
        }
        $gameManager = new GameManager();
        $ticketsModel = $gameManager::getAllTicketsModel();
        foreach ($ticketsModel as $t) {
            $payload = ['gain' => $t['gain'], 'ticket_model_id' => $t['id'], 'user_id' => $userId, 'game_id' => $newGameId];
            $gameManager::createTicket($payload);
        }
    }

    private function getTicketRandom($userId, $gameId)
    {
        $gameManager = new GameManager();
        $tickets = $gameManager::getAllTicketsRemaining($userId, $gameId);
        shuffle($tickets);
        return new Ticket($tickets[0]);
    }

    public function playing()
    {
        $userId = 1;
        $gameId = 1;
        $ticket = $this->getTicketRandom($userId, $gameId);
        $gameManager = new GameManager();
        $gameManager->setDiscoveredTicket($ticket->getId());
    }
}
