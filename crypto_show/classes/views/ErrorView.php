<?php
/**
 * ErrorView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class ErrorView extends WebPageTemplateView
{
    private $error_message;
    private $db_handle;

    public function __construct()
    {
        parent::__construct();
        $this->error_message = '';
        $this->error_message = '';
        $this->db_handle = null;
    }

    public function __destruct(){}

    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    public function createErrorMessage()
    {
        $this->setPageTitle();
        $this->createPageBody();
        $this->createWebPage();
    }

    public function getHtmlOutput()
    {
        return $this->html_page_output;
    }

    private function setPageTitle()
    {
        $app_name = APP_NAME;
        $this->page_title = $app_name . ': processing error...';
    }

    private function createPageBody()
    {
        $address = APP_ROOT_PATH;
        $page_heading = 'CryptoShow System Error';
        $system_message = 'The System Administrator has been notified.';

        $html_output = <<< HTML
<h2>$page_heading</h2>
<p>$this->error_message</p>
<p>$system_message</p>
HTML;
        $this->html_page_content = $html_output;
    }
}

