<?php
/**
 * FunctionsSessions.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class SessionsWrapper
{

    public function __construct(){}

    public function __destruct(){}

    public static function getSession($session_key)
    {
        $session_value = false;
        try
        {
            if (isset($_SESSION[$session_key]))
            {
                $session_value = $_SESSION[$session_key];
            }
        }
        catch (Exception $exception)
        {
            trigger_error ('Session file not available');
        }
        return $session_value;
    }

    public static function setSession($session_key, $session_value)
    {
        $set_session_result = false;
        try
        {
            $_SESSION[$session_key] = $session_value;
            if (isset($_SESSION[$session_key]))
            {
                if (strcmp($_SESSION[$session_key], $session_value) == 0)
                {
                    $set_session_result = true;
                }
            }
        }
        catch (Exception $exception)
        {
            trigger_error ('Session file not available');
        }
        return $set_session_result;
    }

    public static function unsetSession($session_key)
    {
        try
        {
            if (isset($_SESSION[$session_key]))
            {
                unset($_SESSION[$session_key]);
            }
        }
        catch (Exception $exception)
        {
            trigger_error ('Session file not available');
        }
    }

    public static function getAllSessions()
    {
        $session_values = false;
        try
        {
            if (!empty($_SESSION))
            {
                $session_values = var_export($_SESSION, true);
            }
        }
        catch (Exception $exception)
        {
            trigger_error ('Session file not available');
        }
        return $session_values;
    }

    public static function checkLoggedIn()
    {
        $logged_in = false;

        if (SessionsWrapper::getSession('user-id'))
        {
            $logged_in = true;
        }
        return $logged_in;
    }

}
