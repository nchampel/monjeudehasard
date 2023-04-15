<?php

namespace App\Model;

use App\Model\Database;

// include_once("Database.php");

class GameManager extends Database
{

    static function getTicketById($id)
    {
        $sql = "SELECT ticket.*, ticket_values_model.* FROM ticket LEFT JOIN ticket_values_model ON ticket.gain = ticket_values_model.gain WHERE ticket.id = ?";
        $ticket = Parent::selectAll($sql, [$id]);
        return $ticket;
    }

    static function getGameIdByUserId($userId)
    {
        $sql = "SELECT MAX(game_id) as gameId FROM ticket WHERE user_id = ?";
        $ticket = Parent::select($sql, [$userId]);
        return $ticket;
    }

    static function createTicket($payload)
    {
        $payloadForSql = array_values($payload);
        $sql = "INSERT INTO ticket (gain, ticket_model_id, user_id, game_id) VALUES (?, ?, ?, ?)";
        $result = Parent::executeStatement($sql, $payloadForSql);
        if ($result) {
            return array(
                'status' => true,
                'data' => 'Création du ticket effectué',
            );
        }

        return array(
            'status' => false,
            'data' => []
        );
    }

    static function getAllTicketsRemaining($userId, $gameId)
    {
        $sql = "SELECT * FROM ticket WHERE user_id = ? AND game_id = ? AND discovered = 0";
        $tickets = Parent::selectAll($sql, [$userId, $gameId]);
        return $tickets;
    }

    static function setDiscoveredTicket($ticketId)
    {
        $sql = "UPDATE ticket set discovered = 1 WHERE id = ?";
        $result = Parent::executeStatement($sql, [$ticketId]);
        if ($result) {
            return array(
                'status' => true,
                'data' => 'Enregistrement de la découverte du ticket effectuée',
            );
        }

        return array(
            'status' => false,
            'data' => []
        );
    }

    static function getAllTicketsModel()
    {
        $sql = "SELECT * FROM ticket_model";
        $ticketsModel = Parent::selectAll($sql);
        return $ticketsModel;
    }

    static function getValuesTicket($id, $gain)
    {
        $sql = "SELECT *, (SELECT ?) as id FROM ticket_values_model WHERE gain = ?";
        $ticketsModel = Parent::selectAll($sql, [$id, $gain]);
        return $ticketsModel;
    }
}
