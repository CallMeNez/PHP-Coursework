<?php
/**
 * Factory.php
 * PHP web application to demonstrate how databases are accessed securely
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */

class Factory
{

    public function __construct(){}

    public function __destruct(){}

    public static function buildObject($class)
    {
        $object = new $class();
        return $object;
    }

    public static function createDatabaseWrapper()
    {
        $database = Factory::buildObject('DatabaseWrapper');
        $connection_parameters = getPdoDatabaseConnectionDetails();
        $database->setConnectionSettings($connection_parameters);
        $database->connectToDatabase();
        return $database;
    }
}
