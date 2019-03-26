<?php
/**
 * class.CryptoShowLogoutProcessController.php
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

class UserLogoutProcessController extends ControllerAbstract
{
    public function createHtmlOutput()
    {
        $user_logout_result = [];

        $user_logout_result = $this->logoutUser();
        $this->html_output = $this->createView($user_logout_result);
    }

    private function logoutUser()
    {
        $model = Factory::buildObject('UserLogoutProcessModel');

        $model->deleteSession();
        $user_logout_result = $model->getUserLogoutResult();

        return $user_logout_result;

    }

    private function createView($user_logout_result)
    {
        $view = Factory::buildObject('UserLogoutProcessView');

        $view->setUserLogoutResults($user_logout_result);
        $view->createOutputPage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }
}
