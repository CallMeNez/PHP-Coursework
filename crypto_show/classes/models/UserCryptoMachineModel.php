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

    public function setCreateMachineResult()
    {

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
        $user_details = SqlQuery::queryFetchUserDetails();
        $user_machine_count = $user_details['user_machine_count'];
        $user_nickname = $user_details['user_nickname'];

        $sql_query_string = SqlQuery::queryStoreCryptoMachineDetails();
        $sql_query_parameters = array(
            ':cmname' => $this->validated_new_machine_details['validated-cm-name'],
            ':cmmodel' => $this->validated_new_machine_details['validated-cm-model'],
            ':cmdesc' => $this->validated_new_machine_details['validated-cm-description'],
            ':cmcoo' => $this->validated_new_machine_details['validated-cm-coo'],
            ':cmimg' => $this->validated_new_machine_details['validated-cm-image'],
        );

        $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);

        $rows_inserted = $this->database_handle->countRows();
        if ($rows_inserted == 1) {
            $new_machine_details_stored = true;
            $user_machine_count++;
            SqlQuery::queryEditMachineCount($user_machine_count, $user_nickname);
        }
        $this->store_new_machine_result = $this->validated_new_machine_details;
        $this->store_new_machine_result['store_new_machine_result'] = $new_machine_details_stored;
    }
}