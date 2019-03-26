<?php
/**
 * Created by PhpStorm.
 * User: p17160048
 * Date: 25/03/2019
 * Time: 20:34
 */

class UserCryptoMachineFormController extends ControllerAbstract
{
    public function createHtmlOutput()
    {
        $view = Factory::buildObject('UserCryptoMachineFormView');
        $view->createMachineForm();
        $this->html_output = $view->getHtmlOutput();
    }
}
