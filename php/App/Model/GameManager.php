<?php

namespace App\Model;

use App\Model\Database;

// include_once("Database.php");

class GameManager extends Database
{

    static function getTicketById($id)
    {
        $sql = "SELECT * FROM ticket WHERE id = ?";
        $ticket = Parent::select($sql, [$id]);
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
        Parent::executeStatement($sql, $payloadForSql);
    }

    static function getAllTicketsRemaining($userId, $gameId)
    {
        $sql = "SELECT * FROM ticket WHERE user_id = ? AND game_id = ? AND discovered = 0";
        $tickets = Parent::selectAll($sql, [$userId, $gameId]);
        return $tickets;
    }

    static function setDiscoveredTicket($ticketId)
    {
        $sql = "UPDATE ticket set dicovered = 1 WHERE id = ?";
        Parent::executeStatement($sql, [$ticketId]);
    }

    static function getAllTicketsModel()
    {
        $sql = "SELECT * FROM ticket_model";
        $ticketsModel = Parent::selectAll($sql);
        return $ticketsModel;
    }
}
