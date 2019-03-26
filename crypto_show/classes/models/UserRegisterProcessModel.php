
<?php
/**
 * UserRegisterProcessModel.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserRegisterProcessModel extends ModelAbstract
{
    private $store_new_user_details_result;
    private $validated_new_user_details;

    public function __construct()
    {
        parent::__construct();
        $this->store_new_user_details_result = [];
        $this->validated_new_user_details = '';
    }

    public function __destruct(){}

    public function setDatabaseHandle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    public function setValidatedInput($validated_input)
    {
        $this->validated_new_user_details = $validated_input;
    }

    public function getStoreNewUserDetailsResult()
    {
        return $this->store_new_user_details_result;
    }

    public function storeNewUserDetails()
    {
        $new_user_details_stored = false;
        $user_machine_count = 0;
        $user_registered_timestamp = date('Y-m-d H:m:s');

        $user_password = $this->validated_new_user_details['user-password'];
        $user_hashed_password = BcryptWrapper::hashPassword($user_password);

        $sql_query_string = SqlQuery::queryStoreNewUserDetails();
        $sql_query_parameters = array(
            ':usernickname' => $this->validated_new_user_details['validated-user-nickname'],
            ':username' => $this->validated_new_user_details['validated-user-name'],
            ':useremail' => $this->validated_new_user_details['validated-user-email'],
            ':userhashedpassword' => $user_hashed_password,
            ':usermachinecount' => $user_machine_count,
            ':userregisteredtimestamp' => $user_registered_timestamp,
        );

        $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);

        $rows_inserted = $this->database_handle->countRows();

        if ($rows_inserted == 1)
        {
            $new_user_details_stored = true;
        }
        $this->store_new_user_details_result = $this->validated_new_user_details;
        $this->store_new_user_details_result['store-new-user-details-result'] = $new_user_details_stored;
    }
}
