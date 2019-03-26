<?php
/**
 * class.CryptoShowRegisterProcessController.php
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

class UserRegisterProcessController extends ControllerAbstract
{
    public function createHtmlOutput()
    {
        $input_error = true;
        $register_new_user_result = [];

        $validated_input = $this->validate();
        $input_error = $validated_input['input-error'];

        if (!$input_error)
        {
            $register_new_user_result = $this->registerNewUser($validated_input);
        }

        $this->html_output = $this->createView($register_new_user_result);
    }

    private function validate()
    {
        $validate = Factory::buildObject('Validate');
        $tainted = $_POST;

        $cleaned['validated-user-nickname'] = $validate->validateString('new_user_nickname', $tainted, 3, 20);
        $cleaned['validated-user-name'] = $validate->validateString('new_user_name', $tainted, 5, 50);
        $cleaned['validated-user-email'] = $validate->validateEmail('new_user_email', $tainted, 'new_user_email_confirm', 50);
        $cleaned['user-password'] = $tainted['new_user_password'];
        $cleaned['input-error'] = $validate->checkForError($cleaned);

        return $cleaned;
    }

    private function registerNewUser($validated_input)
    {
        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('UserRegisterProcessModel');

        $model->setDatabaseHandle($database);
        $model->getStoreNewUserDetailsResult();

        $model->setValidatedInput($validated_input);
        $model->storeNewUserDetails();
        $register_new_user_results = $model->getStoreNewUserDetailsResult();
        return $register_new_user_results;
}

    private function createView($register_new_user_result)
    {
        $view = Factory::buildObject('UserRegisterProcessView');

        $view->setStoreNewUserDetailsResult($register_new_user_result);
        $view->createOutputPage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }
}
