<?php
/**
 * ErrorModel.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class ErrorModel
{
    private $database_handle;
    private $error_type;
    private $output_error_message;

    public function __construct()
    {
        $this->database_handle = null;
        $this->error_type = '';
        $this->output_error_message = '';
    }

    public function __destruct(){}

    public function getErrorMessage()
    {
        return $this->output_error_message;
    }

    public function setDatabaseHandle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    public function setErrorType($error_type)
    {
        $this->error_type = $error_type;
    }

    public function selectErrorMessage()
    {
        switch ($this->error_type)
        {
            case 'class-not-found-error':
            case 'file-not-found-error':
            default:
                $error_message = 'Ooops - there was an internal error - please try again later';
                break;
        }
        $this->output_error_message = $error_message;
    }

    public function logErrorMessage()
    {
        $user_id = '';

        $number_of_inserted_messages = 0;

        $sql_query_string = SqlQuery::queryLogErrorMessage();
        $sql_parameters = array(':logmessage' => $this->error_type);

        $this->database_handle->safeQuery($sql_query_string, $sql_parameters);
        $number_of_inserted_messages = $this->database_handle->countRows();
    }
}

