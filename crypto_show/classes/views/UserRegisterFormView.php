<?php
/**
 * UserRegisterFormView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserRegisterFormView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct(){}

    public function createRegisterForm()
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
        $page_heading = 'Register a New User';
        $form_method = 'post';
        $form_action = APP_ROOT_PATH;
        $fieldset_legend_text = 'Enter new user details ...';
        $input_field_maximum_size = 50;
        $input_field_maximum_characters = 50;

        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
<form method="$form_method" action="$form_action">
<fieldset><legend>$fieldset_legend_text</legend>
<p>User nickname: <input type="text" name="new_user_nickname" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Enter user id (3 - 20 characters)" required="required" /></p>
<p>Name: <input type="text" name="new_user_name" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Enter your name (5 - 50 characters)" required="required" /></p>
<p>Email: <input type="text" name="new_user_email" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Enter a valid email address" required="required" /></p>
<p>Confirm email: <input type="text" name="new_user_email_confirm" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Re-enter your email address to confirm" required="required" /></p>
<p>Password: <input type="password" name="new_user_password" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Password (8 to 50 characters)" required="required" /></p>
<p>Confirm password: <input type="password" name="new_user_password_check" value="" size="$input_field_maximum_characters" maxlength="$input_field_maximum_characters" placeholder="Confirm password" required="required" /></p>
<p><button name="feature" value="process_new_user_details">Store new user details</button></p>
</fieldset>
</form>
HTMLFORM;
    }
}
