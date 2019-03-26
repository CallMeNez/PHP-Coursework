<?php
/**
 * UserLoginFormView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLoginFormView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct(){}

    public function createLoginForm()
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
        $this->page_title = APP_NAME . ' Register a new User';
    }

    private function createPageBody()
    {
        $page_heading = 'User Login';
        $form_method = 'post';
        $form_action = APP_ROOT_PATH;
        $fieldset_legend_text = 'Enter your login details ...';
        $input_field_maximum_size = 50;
        $input_field_maximum_characters = 50;

        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
<form method="$form_method" action="$form_action">
<fieldset><legend>$fieldset_legend_text</legend>
<p>User nickname: <input type="text" name="new_user_nickname" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Enter user id (3 - 20 characters)" required="required" /></p>
<p>Password: <input type="password" name="new_user_password" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Password (8 to 50 characters)" required="required" /></p>
<p><button name="feature" value="process_login">Login</button></p>
</fieldset>
</form>
HTMLFORM;
    }
}
