<?php
/**
 * UserLogoutProcessModel.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLogoutProcessModel extends ModelAbstract
{
    private $user_logout_result;

    public function __construct()
    {
        parent::__construct();
        $this->user_logout_result = [];
    }

    public function __destruct(){}

    public function setDatabaseHandle($database_handle){}

    public function getUserLogoutResult()
    {
        return $this->user_logout_result;
    }

    public function setValidatedInput($validated_input){}

    public function deleteSession()
    {
        $user_logout_result = false;
        $user_logout = [];
        $session_file_path_and_name = '';
        $session_index = session_id();
        $user_logout['user_nickname'] = SessionsWrapper::getSession('user-nickname');

        if ($session_index != '')
        {
            $session_save_path = ini_get('session.save_path');
            $session_name = ini_get('session.name');
            $session_file_path_and_name = $session_save_path . '/' . $session_name . '_' . $session_index;

            setcookie ($session_index, "", time() - 3600);
            unset ($_SESSION);
            session_destroy();
            session_unset();
        }

        if (!file_exists($session_file_path_and_name))
        {
            $user_logout_result= true;
        }

        $user_logout['logout-result'] = $user_logout_result;

        $this->user_logout_result = $user_logout;
    }
}
