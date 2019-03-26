<?php
/**
 * Created by PhpStorm.
 * User: p17160048
 * Date: 25/03/2019
 * Time: 21:28
 */

class UserCryptoMachineProcessController extends ControllerAbstract
{
    public function createHtmlOutput()
    {

        $input_error = true;
        $create_machine_result = [];

        $validated_input = $this->validate();
        $input_error = $validated_input['input-error'];

        if (!$input_error)
        {
            $create_machine_result = $this->createMachine($validated_input);
        }

        $this->html_output = $this->createView($create_machine_result);

    }

    private function validate()
    {
        $validate = Factory::buildObject('Validate');
        $tainted = $_POST;

        $cleaned['validated-cm-name'] = $validate->validateString('crypto_machine_name', $tainted, 1, 255);
        $cleaned['validated-cm-model'] = $validate->validateString('crypto_machine_model', $tainted, 1, 255);
        $cleaned['validated-cm-description'] = $validate->validateString('crypto_machine_description', $tainted, 1, 400);
        $cleaned['validated-cm-coo'] = $validate->validateString('crypto_machine_country_of_origin', $tainted, 1, 255);
        $cleaned['validated-cm-image'] = $tainted['crypto_machine_image'];
        $cleaned['validated-cm-nick'] = $validate->validateString('user_nickname', $tainted, 3, 20);
        $cleaned['input-error'] = $validate->checkForError($cleaned);

        return $cleaned;
    }

    private function createMachine($validated_input)
    {

        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('UserCryptoMachineModel');

        $model->setDatabaseHandle($database);

        $model->setValidatedInput($validated_input);
        $model->storeNewMachineDetails();
        $create_machine_result = $model->getStoreNewMachineResult();

        return $create_machine_result;
    }

    private function createView($create_machine_result)
    {
        $view = Factory::buildObject('UserCryptoMachineProcessView');

        $view->setCreateMachineResult($create_machine_result);
        $view->createOutputPage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }
}