<?php
/**
 * UserLoginProcessView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLoginProcessView extends WebPageTemplateView
{
    private $authenticate_user_results;
    private $output_content;

    public function __construct()
    {
        parent::__construct();
        $this->authenticate_user_results = [];
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

    public function setUserLoginResult($login_user_result)
    {
        $this->authenticate_user_results = $login_user_result;
    }

    private function setPageTitle()
    {
        $this->page_title = APP_NAME . ': Login User';
    }

    private function createAppropriateOutputMessage()
    {
        $output_content = '';
        if (isset($this->authenticate_user_results['input-error']))
        {
            if ($this->authenticate_user_results['input-error'] === false)
            {
                if (isset($this->authenticate_user_results['user-authenticated']))
                {
                    if ($this->authenticate_user_results['user-authenticated'])
                    {
                        $output_content .= $this->createSuccessMessage();
                    }
                    else
                    {
                        $output_content .= $this->createErrorMessage();
                    }
                }
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
        $page_heading = 'User Login';

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
<p>Login failed - please try again.</p>
<form method="$form_method" action="$form_action">
<p><button name="feature" value="user_login" /><img src="$path_to_image" alt="Sad face" /><br />Try again</button></p>
</form>
HTMLOUTPUT;
        return $page_content;
    }

    private function createSuccessMessage()
    {
        $path_to_image = MEDIA_PATH . 'happy_face.jpg';
        $user_name = $this->authenticate_user_results['user-details']['user-name'];
        $register_timestamp = $this->authenticate_user_results['user-details']['user-registered-timestamp'];
        $machine_count = $this->authenticate_user_results['user-details']['user-machine-count'];
        $page_content = <<< HTMLOUTPUT
<p>Welcome back $user_name</p>
<p>You have successfully logged in.</p>
<p>You have been a member of this site since $register_timestamp</p>
<p>You have $machine_count cryptographic machines currently listed on the site.</p>
<p><button name="feature" value="user_login" /><img src="$path_to_image" alt="Happy face" /></button></p>
HTMLOUTPUT;
        return $page_content;
    }
}
