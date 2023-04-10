<?php

namespace App\Model;

include_once("inc/config.php");

use Exception;
use mysqli;

/**
 * Database - Le modèle de base pour tous les autres modèles. Ils étendent (extends) tous celui-ci
 *
 */

class Database
{
    protected static $connection;

    public function __construct()
    {
        try {
            Self::$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

            if (mysqli_connect_errno()) {
                throw new Exception("Impossible de se connecter à la base de données.");
            }
            Self::$connection->set_charset("utf8");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function select($query = "", $params = [])
    {
        try {
            $stmt = Self::executeStatement($query, $params);
            if ($result = $stmt->get_result())
                $row = $result->fetch_assoc();
            $stmt->close();

            return $row;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    /**
     * selectAll
     *
     * Fonction de requête Select SQL avec paramètres ou non poour retourner une liste d'éléments
     *
     * @param string $query Requête SQL des models étendus
     * @param array $params Paramètres de la requête
     * @return mixed Anonyme
     */
    public static function selectAll($query = "", $params = [])
    {
        try {
            $stmt = Self::executeStatement($query, $params);
            if ($result = $stmt->get_result())
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $rows;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }


    /**
     * executeStatement
     *
     * Cette fonction profite des avantages des méthodes préparées SQLi afin de créer une requête préparée et l'exécuter. 
     * Lie les paramètres grâce à la méthode bind_param. Les types pour la fonction sont créés dynamiquement.
     *
     * @param string $query Requête qui sera exécutée
     * @param array $params Paramètres de la requête
     * @return mysqli_stmt/bool Retourne le résultat de la requête avec un booléen de réussite ou échec d'exécution 
     */
    public static function  executeStatement($query = "", $params = [])
    {
        try {
            $stmt = Self::$connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Impossible de préparer la requête: " . $query);
            }

            if ($params) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * lastInsertedId
     *
     * Utilise la connexion en bdd pour retourner le dernier id inséré en bdd
     * 
     * @param void
     * @return int Anonyme
     */
    public static function lastInsertedId()
    {
        return Self::$connection->insert_id;
    }
}
