<?php
/**
 * ModelAbstract.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

abstract class ModelAbstract
{
    protected $database_handle;
    protected $database_connection_messages;

    public function __construct()
    {
        $this->database_handle = null;
        $this->database_connection_messages = [];
    }

    abstract protected function setDatabaseHandle($database_handle);

    abstract protected function setValidatedInput($sanitised_input);
}
