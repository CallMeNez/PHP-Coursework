<?php
/**
 * UserLoginProcessModel.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLoginProcessModel extends ModelAbstract
{
    private $login_user_result;
    private $logged_in_user_details;

    public function __construct()
    {
        parent::__construct();
        $this->login_user_result = [];
        $this->logged_in_user_details = '';
    }

    public function __destruct(){}

    public function setDatabaseHandle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    public function getUserLoginResult()
    {
        return $this->login_user_result;
    }

    public function setValidatedInput($validated_input)
    {
        $this->login_user_result = $validated_input;
    }

    public function processUserLogin()
    {
        $authenticated_user = false;
        $user_details = '';

        $authenticated_user = $this->authenticateUser();

        if ($authenticated_user === true)
        {
            $user_details = $this->fetchAuthenticatedUserDetails();
            $this->updateUserSession($user_details);
        }

        $this->login_user_result['user-authenticated'] = $authenticated_user;
        $this->login_user_result['user-details'] = $user_details;
    }

    private function authenticateUser()
    {
        $authenticated_user = false;
        $user_password = $this->login_user_result['user-password'];

        $sql_query_string = SqlQuery::queryAuthenticateUser();

        $sql_query_parameters = [
            ':usernickname' => $this->login_user_result['validated-user-nickname']
        ];

        $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);

        $row_count = $this->database_handle->countRows();

        if ($row_count == 1)
        {
            $user_recordset = $this->database_handle->safeFetchRow();
            $stored_password = $user_recordset[0];
            $authenticated_user = BcryptWrapper::validatePassword($user_password, $stored_password);
        }

        return $authenticated_user;
    }

    private function fetchAuthenticatedUserDetails()
    {
        $user_details = [];

        $sql_query_parameters = [
            ':usernickname' => $this->login_user_result['validated-user-nickname']
        ];

        $sql_query_string = SqlQuery::queryFetchUserDetails();
        $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);

        $user_recordset = $this->database_handle->safeFetchArray();

        $user_details['user-id'] = $user_recordset['user_id'];
        $user_details['user-nickname'] = $this->login_user_result['validated-user-nickname'];
        $user_details['user-name'] = $user_recordset['user_name'];
        $user_details['user-email'] = $user_recordset['user_email'];
        $user_details['user-machine-count'] = $user_recordset['user_machine_count'];
        $user_details['user-registered-timestamp'] = $user_recordset['user_registered_timestamp'];

        return $user_details;
    }

    public function updateUserSession($user_login_result)
    {
        $set_session_result = SessionsWrapper::setSession('user-nickname', $user_login_result['user-nickname']);
        $set_session_result = SessionsWrapper::setSession('user-id', $user_login_result['user-id']);
    }
}
