<?php
/**
 * UserLoginFormController.php
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

class UserLoginFormController extends ControllerAbstract
{
    public function createHtmlOutput()
    {
        $view = Factory::buildObject('UserLoginFormView');
        $view->createLoginForm();
        $this->html_output = $view->getHtmlOutput();
    }
}
