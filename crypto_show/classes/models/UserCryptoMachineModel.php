<?php
/**
 * Created by PhpStorm.
 * User: p17160048
 * Date: 25/03/2019
 * Time: 16:07
 */

class UserCryptoMachineModel extends ModelAbstract
{
    private $store_new_machine_result;
    private $validated_new_machine_details;

    public function __construct()
    {
        parent::__construct();
        $this->store_new_machine_result = [];
        $this->validated_new_machine_details = '';
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function setDatabaseHandle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    public function setValidatedInput($sanitised_input)
    {
        $this->validated_new_machine_details = $sanitised_input;
    }

    /**
     * @return array
     */
    public function getStoreNewMachineResult()
    {
        return $this->store_new_machine_result;
    }

    public function storeNewMachineDetails()
    {
        $new_machine_details_stored = false;
        $user_nickname = $this->validated_new_machine_details['validated-cm-nick'];
        $sql_query_string = SqlQuery::queryFetchReducedUserDetails();
        $sql_query_parameters = [
            ':usernickname' => $this->validated_new_machine_details['validated-cm-nick'],
        ];
        $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);
        $user_details_query_results = $this->database_handle->safeFetchArray();
        $user_id = $user_details_query_results['user_id'];
        $user_machine_count = $user_details_query_results['user_machine_count'];

        //  array (size=2)
        //'user_id' => string '1' (length=1)
        //'user_machine_count' => string '0' (length=1)
        if ($user_machine_count < 10)
        {
            $sql_query_string = SqlQuery::queryStoreCryptoMachineDetails();
            $sql_query_parameters = array(
                ':uid' => $user_id,
                ':cmname' => $this->validated_new_machine_details['validated-cm-name'],
                ':cmmodel' => $this->validated_new_machine_details['validated-cm-model'],
                ':cmdesc' => $this->validated_new_machine_details['validated-cm-description'],
                ':cmcoo' => $this->validated_new_machine_details['validated-cm-coo'],
                ':cmimg' => $this->validated_new_machine_details['validated-cm-image'],
            );

            $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);
        }

        if ($query_result['database-query-execute-error'] == false) {
            $new_machine_details_stored = true;
            $sql_query_string = SqlQuery::queryEditMachineCount();
            $user_machine_count = $user_machine_count+1;
            $sql_query_parameters = [
                ':uid' => $user_id,
                ':machinecount' => $user_machine_count,
            ];
            $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);
        }
        $this->store_new_machine_result = $this->validated_new_machine_details;
        $this->store_new_machine_result['store_new_machine_result'] = $new_machine_details_stored;
    }
}