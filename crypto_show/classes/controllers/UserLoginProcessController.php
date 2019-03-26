<?php
/**
 * class.CryptoShowLoginProcessController.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLoginProcessController extends ControllerAbstract
{
    public function createHtmlOutput()
    {

        $input_error = true;
        $login_user_result = [];

        $validated_input = $this->validate();
        $input_error = $validated_input['input-error'];

        if (!$input_error)
        {
            $login_user_result = $this->loginUser($validated_input);
        }

        $this->html_output = $this->createView($login_user_result);

    }

    private function validate()
    {
        $validate = Factory::buildObject('Validate');
        $tainted = $_POST;

        $cleaned['validated-user-nickname'] = $validate->validateString('new_user_nickname', $tainted, 3, 20);
        $cleaned['user-password'] = $tainted['new_user_password'];
        $cleaned['input-error'] = $validate->checkForError($cleaned);

        return $cleaned;
    }

    private function loginUser($validated_input)
    {

        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('UserLoginProcessModel');

        $model->setDatabaseHandle($database);

        $model->setValidatedInput($validated_input);
        $model->processUserLogin();
        $login_user_result = $model->getUserLoginResult();

        return $login_user_result;
    }

    private function createView($login_user_results)
    {
        $view = Factory::buildObject('UserLoginProcessView');

        $view->setUserLoginResult($login_user_results);
        $view->createOutputPage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }

}
