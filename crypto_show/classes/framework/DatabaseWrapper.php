<?php
/**
 * DatabaseWrapper.php
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class DatabaseWrapper
{
    private $database_connect_details;
    private $database_connection_messages;
    private $database_handle;
    private $prepared_statement;

    public function __construct()
    {
        $this->database_connect_details = [];
        $this->database_handle = null;
        $this->prepared_statement = null;
        $this->database_connection_messages = [];
    }

    /**
     * ensure disconnection of all service handles
     */
    public function __destruct() { $this->database_handle = null; }

    /**
     * Assign the connection settings array to a class attribute
     *
     * @param $connection_settings
     */
    public function setConnectionSettings($connection_settings)
    {
        $this->database_connect_details = $connection_settings;
    }

    /**
     * connect to the required database
     * generate error messages on error
     */
    public function connectToDatabase()
    {
        $database_connection_error = false;
        $pdo_dsn = $this->database_connect_details['pdo_dsn'];
        $pdo_user_name = $this->database_connect_details['pdo_user_name'];
        $pdo_user_password = $this->database_connect_details['pdo_user_password'];

        // attempt to connect to database server & specified database
        try
        {
            $this->database_handle = new PDO($pdo_dsn, $pdo_user_name, $pdo_user_password);
            $this->database_connection_messages['connection'] = 'Connected to the database.';
        }
        catch (PDOException $exception_object)
        {
            $this->database_connection_messages['connection'] = 'Cannot connect to the database.';
            $database_connection_error = true;
            trigger_error($exception_object);
        }
        $this->database_connection_messages['database-connection-error'] = $database_connection_error;
    }

    public function getConnectionMessages()
    {
        return $this->database_connection_messages;
    }

    /**
     * using prepared statements
     *
     * @param $query_string
     * @param null $query_parameters
     * @return array
     */
    public function safeQuery($query_string, $query_parameters = null)
    {
        $database_query_execute_error = false;

        try
        {
            $temp = [];
            $this->database_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->prepared_statement = $this->database_handle->prepare($query_string);

            $execute_result = $this->prepared_statement->execute($query_parameters);
            $this->database_connection_messages['execute-OK'] = $execute_result;
        }
        catch (PDOException $exception_object)
        {
            $error_message  = 'PDO Exception caught. ';
            $error_message .= 'Error with the database access. ';
            $error_message .= 'SQL query: ' . $query_string;
            $error_message .= 'Error: ' . print_r($this->prepared_statement->errorInfo(), true) . "\n";
            // NB would usually output to file for sysadmin attention
            $database_query_execute_error = true;
            $this->database_connection_messages['sql-error'] = $error_message;
            $this->database_connection_messages['pdo-error-code'] = $this->prepared_statement->errorInfo();
            trigger_error($exception_object);
        }
        $this->database_connection_messages['database-query-execute-error'] = $database_query_execute_error;
        return $this->database_connection_messages;
    }

    /**
     * count number of returned rows in the returned record set
     *
     * @return mixed
     */
    public function countRows()
    {
        $num_rows = $this->prepared_statement->rowCount();
        return $num_rows;
    }

    /**
     * count number of returned fields in the record set
     *
     * @param $query_result
     * @return mixed
     */
    public function countFields()
    {
        $num_fields = $this->prepared_statement->columnCount();
        return $num_fields;
    }

    /**
     * return the record set with field indices
     *
     * @return mixed
     */
    public function safeFetchRow()
    {
        $row = $this->prepared_statement->fetch(PDO::FETCH_NUM);
        return $row;
    }

    /**
     * return the record set with field names
     *
     * @return mixed
     */
    public function safeFetchArray()
    {
        $row = $this->prepared_statement->fetch(PDO::FETCH_ASSOC);
        if (is_array($row))
        {
            $row = $this->escapeOutput($row);
        }
        return $row;
    }

    /**
     * return the record set as an object
     *
     * @return mixed
     */
    public function safeFetchAllResults()
    {
        $row = $this->prepared_statement->fetchAll();
        return $row;
    }

    /**
     * return the record set as an object
     *
     * @return mixed
     */
    public function safeFetchObject()
    {
        $row = $this->prepared_statement->fetchObject();
        return $row;
    }

    /**
     * get id of last inserted row (auto-increment field)
     *
     * @return mixed
     */
    public function lastInsertedId()
    {
        $sql_query = 'SELECT LAST_INSERT_ID()';

        $this->safeQuery($sql_query);
        $last_inserted_id = $this->safeFetchArray();
        $last_inserted_id = $last_inserted_id['LAST_INSERT_ID()'];
        return $last_inserted_id;
    }

    /**
     * Dumps the information contained by a prepared statement directly on the output.
     * It will provide the SQL query in use, the number of parameters used (Params),
     * the list of parameters, with their name, type (paramtype) as an integer, their
     * key name or position, the value, and the position in the query (if this is
     * supported by the PDO driver, otherwise, it will be -1).
     *
     * @return $debug_dump_params
     */
    public function debugDumpParameters()
    {
        $debug_dump_params = $this->prepared_statement->debugDumpParams();
        return $debug_dump_params;
    }

    /**
     * apply htmlspecialchars function to each value in an array of data returned from the database
     *
     * @param array $row
     * @return array
     */
    private function escapeOutput(array $row)
    {
        $output_row = [];
        foreach ($row as $key => $item)
        {
            $output_row[$key] = htmlspecialchars($item);
        }
        return $output_row;
    }
}

