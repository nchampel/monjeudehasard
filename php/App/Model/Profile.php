<?php

namespace App\Model;

use App\Model\Database;

// include_once("Database.php");

class TicketModel extends Database
{
    private $id;
    private $pot;
    private $try_a_day;
    private $try_remaining;

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

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pot
     */
    public function getPot()
    {
        return $this->pot;
    }

    /**
     * Set the value of pot
     *
     * @return  self
     */
    public function setPot($pot)
    {
        $this->pot = $pot;

        return $this;
    }

    /**
     * Get the value of try_a_day
     */
    public function getTry_a_day()
    {
        return $this->try_a_day;
    }

    /**
     * Set the value of try_a_day
     *
     * @return  self
     */
    public function setTry_a_day($try_a_day)
    {
        $this->try_a_day = $try_a_day;

        return $this;
    }

    /**
     * Get the value of try_remaining
     */
    public function getTry_remaining()
    {
        return $this->try_remaining;
    }

    /**
     * Set the value of try_remaining
     *
     * @return  self
     */
    public function setTry_remaining($try_remaining)
    {
        $this->try_remaining = $try_remaining;

        return $this;
    }
}
