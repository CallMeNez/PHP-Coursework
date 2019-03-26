<?php
/**
 * ErrorController.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class ErrorController
{
    private $html_output;
    private $error_type;
    private $output_error_message;

    public function __construct()
    {
        $this->html_output = '';
        $this->error_type = '';
        $this->output_error_message = '';
    }

    public function __destruct(){}

    public function getHtmlOutput()
    {
        return $this->html_output;
    }

    public function setErrorType($error_type)
    {
        $this->error_type = $error_type;
    }

    public function processError()
    {
        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('ErrorModel');

        $model->setDatabaseHandle($database);
        $model->setErrorType($this->error_type);
        $model->selectErrorMessage();
        $model->logErrorMessage();

        $this->output_error_message = $model->getErrorMessage();
    }

    public function createHtmlOutput()
    {
        $view = Factory::buildObject('ErrorView');
        $view->setErrorMessage($this->output_error_message);
        $view->createErrorMessage();
        $this->html_output = $view->getHtmlOutput();
    }

}

