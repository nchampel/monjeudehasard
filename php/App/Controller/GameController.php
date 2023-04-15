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

    public function initGame($request, $response)
    {
        $userId = 1;
        $Response = [];
        try {
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
                $result = $gameManager::createTicket($payload);
            }
            if ($result['status']) {
                $Response['status'] = 200;
                $Response['data'] = $payload;
                $Response['message'] = 'Tickets créés avec succès.';
                $response->code(200)->json($Response);
                return;
            }

            $Response['status'] = 400;
            $Response['data'] = [];
            $Response['message'] = 'Une erreur inattendue s\'est produite. Veuillez réessayer.';

            $response->code(400)->json($Response);
            return;
        } catch (Exception $e) {
            $Response['status'] = 500;
            $Response['message'] = $e->getMessage();
            $Response['data'] = [];

            $response->code(500)->json($Response);
            return;
        }
    }

    private function getTicketRandom($userId, $gameId)
    {
        $gameManager = new GameManager();
        $tickets = $gameManager::getAllTicketsRemaining($userId, $gameId);
        shuffle($tickets);
        $ticket = new Ticket($tickets[0]);
        $ticketsWithValues = $gameManager::getValuesTicket($ticket->getId(), $ticket->getGain());
        $index = rand(0, count($ticketsWithValues) - 1);
        return $ticketsWithValues[$index];
        // return new Ticket($ticket);
    }

    public function playing($request, $response)
    {
        $userId = 1;
        $gameId = 1;
        $Response = [];
        try {
            $ticket = $this->getTicketRandom($userId, $gameId);
            $gameManager = new GameManager();
            $result = $gameManager->setDiscoveredTicket((int)$ticket['id']);
            if ($result['status']) {
                $Response['status'] = 200;
                $Response['data'] = $ticket;
                $Response['message'] = 'Ticket récupéré avec succès.';
                $response->code(200)->json($Response);
                return;
            }
            $Response['status'] = 400;
            $Response['data'] = [];
            $Response['message'] = 'Une erreur inattendue s\'est produite. Veuillez réessayer.';

            $response->code(400)->json($Response);
            return;
        } catch (Exception $e) {
            $Response['status'] = 500;
            $Response['message'] = $e->getMessage();
            $Response['data'] = [];

            $response->code(500)->json($Response);
            return;
        }
    }
}
