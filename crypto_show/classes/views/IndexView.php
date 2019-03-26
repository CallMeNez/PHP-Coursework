<?php
/**
 * IndexView.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class IndexView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct(){}

    public function createForm()
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
        $this->page_title = APP_NAME . ' Index Page';
    }

    private function createPageBody()
    {
        $year = date('Y');
        $info_text = '';
        $info_text .= 'Welcome to the Cryptographic Machine Show web-site ' . $year;
        $info_text .= '<br />';
        $info_text .= 'The web-site will allow users to view and maintain their details and add/maintain details of their cryptographic machines.';
        $info_text .= '<br />';
        $info_text .= 'New users can register, registered users can login.';
        $info_text .= '<br />';
        $info_text .= 'Once logged in, users may add details of their cryptographic machines.';
        $info_text .= '<br />';
        $info_text .= 'Please select an action from the menu above';
        $page_heading = APP_NAME . ' demonstration';

        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
<p>$info_text</p>
HTMLFORM;
    }
}
