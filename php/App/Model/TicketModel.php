<?php

namespace App\Model;

use App\Model\Database;

// include_once("Database.php");

class TicketModel extends Database
{
    private $id;
    private $gain;

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
}
