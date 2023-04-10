<?php

namespace App\Model;

use App\Model\Database;

// include_once("Database.php");

class Ticket extends Database
{
    private $id;
    private $gain;
    private $discovered;
    private $ticket_model_id;
    private $user_id;
    private $game_id;

    function __construct(array $values = [])
    {
        new Database();
        $this->hydratation($values);
    }

    public function hydratation($values)
    {
        $proprietes = get_object_vars($this);
        $keysValeurs = array_keys($proprietes);
        foreach ($keysValeurs as $prop) {
            if (isset($values[$prop])) {
                $setKey = 'set' . ucfirst($prop);
                $this->$setKey($values[$prop]);
            }
        }
    }

    static function getTicketById($id)
    {
        $sql = "SELECT * FROM ticket WHERE id = ?";
        $ticket = Parent::select($sql, [$id]);
        print_r($ticket);
    }

    /**
     * Get the value of gain
     */
    public function getGain()
    {
        return $this->gain;
    }

    /**
     * Set the value of gain
     *
     * @return  self
     */
    public function setGain($gain)
    {
        $this->gain = $gain;

        return $this;
    }

    /**
     * Get the value of discovered
     */
    public function getDiscovered()
    {
        return $this->discovered;
    }

    /**
     * Set the value of discovered
     *
     * @return  self
     */
    public function setDiscovered($discovered)
    {
        $this->discovered = $discovered;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of game_id
     */
    public function getGame_id()
    {
        return $this->game_id;
    }

    /**
     * Set the value of game_id
     *
     * @return  self
     */
    public function setGame_id($game_id)
    {
        $this->game_id = $game_id;

        return $this;
    }

    /**
     * Get the value of ticket_model_id
     */
    public function getTicket_model_id()
    {
        return $this->ticket_model_id;
    }

    /**
     * Set the value of ticket_model_id
     *
     * @return  self
     */
    public function setTicket_model_id($ticket_model_id)
    {
        $this->ticket_model_id = $ticket_model_id;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}
