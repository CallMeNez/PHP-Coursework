<?php
/**
 * UserLogoutProcessView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class UserLogoutProcessView extends WebPageTemplateView
{
    private $user_logout_results;
    private $output_content;

    public function __construct()
    {
        parent::__construct();
        $this->user_logout_results = [];
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

    public function setUserLogoutResults($user_logout_result)
    {
        $this->user_logout_results = $user_logout_result;
    }

    private function setPageTitle()
    {
        $this->page_title = APP_NAME . ': User Logout';
    }

    private function createAppropriateOutputMessage()
    {
        $output_content = '';
        if (isset($this->user_logout_results['logout-result']))
        {
            if ($this->user_logout_results['logout-result'])
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
        $page_heading = 'User Logout';

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
<p>Ooops - there appears to have been an error in logging you out - please try again.</p>
<form method="$form_method" action="$form_action">
<p><button name="feature" value="user_logout" /><img src="$path_to_image" alt="Sad face" /><br />Try again</button></p>
</form>
HTMLOUTPUT;
        return $page_content;
    }

    private function createSuccessMessage()
    {
        $path_to_image = MEDIA_PATH . 'happy_face.jpg';
        $user_nickname = $this->user_logout_results['user_nickname'];
        $page_content = <<< HTMLOUTPUT
<p>$user_nickname: You have been successfully logged out.</p>
<p><button name="feature" value="user_logout" /><img src="$path_to_image" alt="Happy face" /></button></p>
HTMLOUTPUT;
        return $page_content;
    }
}
