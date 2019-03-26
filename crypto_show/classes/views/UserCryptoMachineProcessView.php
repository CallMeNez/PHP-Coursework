<?php
/**
 * Created by PhpStorm.
 * User: p17160048
 * Date: 25/03/2019
 * Time: 21:59
 */

class UserCryptoMachineProcessView extends WebPageTemplateView
{
    private $authenticate_cm_results;
    private $output_content;

    public function __construct()
    {
        parent::__construct();
        $this->authenticate_cm_results = [];
        $this->output_content = '';
    }

    public function __destruct(){}

    public function createOutputPage()
    {
        $this->setPageTitle();
        $this->createAppropriateOutputMessage();
        $this->createPageBody();
        $this->createWebPage();
    }

    public function getHtmlOutput()
    {
        return $this->html_page_output;
    }

    public function setCreateMachineResult($crypto_machine_result)
    {
        $this->authenticate_cm_results = $crypto_machine_result;
    }

    private function setPageTitle()
    {
        $this->page_title = APP_NAME . ': Crypto Machine';
    }

    private function createAppropriateOutputMessage()
    {
        $output_content = '';
        if (isset($this->authenticate_cm_results['store_new_machine_result']))
        {
            if ($this->authenticate_cm_results['store_new_machine_result'] === true)
            {
                $output_content .= $this->createSuccessMessage();
            }
                else
                {
                    $output_content .= $this->createErrorMessage();
                }
        }
        else
        {
            $output_content .= 'Ooops - something appears to have gone wrong.  Please try again later.';
        }

        $this->output_content = $output_content;
    }

    private function createPageBody()
    {
        $page_heading = 'Crypto Machine';
        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
$this->output_content
HTMLFORM;
    }

    private function createErrorMessage()
    {
        $path_to_image = MEDIA_PATH . 'sad_face.jpg';
        $form_method = 'post';
        $form_action = APP_ROOT_PATH;

        $page_content = <<< HTMLOUTPUT
<p>Crypto Machine Store Failed - please try again.</p>
<form method="$form_method" action="$form_action">
<p><button name="feature" value="CM" /><img src="$path_to_image" alt="Sad face" /><br />Try again</button></p>
</form>
HTMLOUTPUT;
        return $page_content;
    }

    private function createSuccessMessage()
    {
        $path_to_image = MEDIA_PATH . 'happy_face.jpg';
        $cm_name = $this->authenticate_cm_results['validated-cm-name'];
        $page_content = <<< HTMLOUTPUT
<p> $cm_name has been successfully stored!</p>
HTMLOUTPUT;
        return $page_content;
    }
}