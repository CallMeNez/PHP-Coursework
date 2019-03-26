<?php
/**
 * Created by PhpStorm.
 * User: p17160048
 * Date: 25/03/2019
 * Time: 20:36
 */

class UserCryptoMachineFormView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct(){}

    public function createMachineForm()
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
        $this->page_title = APP_NAME . 'Create a new Crypto Machine Entry';
    }

    private function createPageBody()
    {
        $page_heading = 'Crypto Machine Entry';
        $form_method = 'post';
        $form_action = APP_ROOT_PATH;
        $fieldset_legend_text = 'Enter Crypto Machine details ...';
        $input_field_maximum_size = 255;
        $input_field_maximum_characters = 400;
        $nickname_min = 3;
        $nickname_max = 20;

        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
<form method="$form_method" action="$form_action">
<fieldset><legend>$fieldset_legend_text</legend>
<p>Crypto Machine Name: <input type="text" name="crypto_machine_name" value="" size="$input_field_maximum_size" maxlength="$input_field_maximum_size" placeholder="Enter machine name (255 characters max)" required="required" /></p>
<p>Crypto Machine Model: <input type="text" name="crypto_machine_model" value="" size="$input_field_maximum_size" maxlength="$input_field_maximum_size" placeholder="Enter machine model (255 characters max)" /></p>
<p>Crypto Machine Description: <input type="text" name="crypto_machine_description" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Enter machine description (400 characters max)" /></p>
<p>Crypto Machine Country of Origin: <input type="text" name="crypto_machine_country_of_origin" value="" size="$input_field_maximum_size" maxlength="$input_field_maximum_size" placeholder="Enter the country of origin (255 characters max)" /></p>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
<p>Crypto Machine Image: <input type="file" name="crypto_machine_image" value="" size="1MB" maxlength="" /></p>
<p>Article Author Nickname: <input type="text" name="user_nickname" value="" size="$nickname_min" maxlength="$nickname_max" placeholder="Tag this machine with your Nickname" required="required" /></p>
<p><button name="feature" value="process_create_machine">Create Machine</button></p>
</fieldset>
</form>
HTMLFORM;
    }
}