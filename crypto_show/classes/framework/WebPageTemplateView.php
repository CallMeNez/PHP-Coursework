<?php
 /**
  * WebPageTemplateView.php
  *
  * @author CF Ingrams - cfi@dmu.ac.uk
  * @copyright De Montfort University
  *
  * @package crypto-show
  */

 class WebPageTemplateView
 {
  private $menu_bar;
  protected $page_title;
  protected $html_page_content;
  protected $html_page_output;

  public function __construct()
  {
   $this->page_title = '';
   $this->html_page_content = '';
   $this->html_page_output = '';
   $this->menu_bar = '';
  }

  public function __destruct(){}

  public function createWebPage()
  {
   $this->createMenuBar();
   $this->createWebPageMetaHeadings();
   $this->insertPageContent();
   $this->createWebPageFooter();
  }

  private function createWebPageMetaHeadings()
  {
   $css_filename = CSS_PATH . CSS_FILE_NAME;
   $html_output = <<< HTML
<!doctype html >
<html lan=""en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-gb" />
<meta name="author" content="Clinton Ingrams" />
<link rel="stylesheet" href="$css_filename" type="text/css" />
<title>$this->page_title</title>
</head>
<body>
HTML;
   $this->html_page_output .= $html_output;
  }

  private function insertPageContent()
  {
   $landing_page = APP_ROOT_PATH;
   $html_output = <<< HTML
<div id="banner-div">
<h1>The Cryptographic Machine Show</h1>
<p class="cent">
Page last updated on <script type="text/javascript">document.write(document.lastModified)</script>
<br />
Maintained by <a href="mailto:cfi@dmu.ac.uk">cfi@dmu.ac.uk</a>
</p>
<hr class="deepline"/>
$this->menu_bar
<hr class="deepline"/>
</div>
<div id="clear-div"></div>
<div id="page-content-div">
$this->html_page_content
<p class="curr_page"><a href="$landing_page">Return to Home page</a></p>
</div>
HTML;
   $this->html_page_output .= $html_output;
  }

  private function createMenuBar()
  {
   $menu_option_buttons = '';

   $logged_in = SessionsWrapper::checkLoggedIn();

   $menu_option_buttons .= '<button name="feature" value="user_register">Register</button>';
   $menu_option_buttons .= '&nbsp;&nbsp;';
   if ($logged_in)
   {
    $menu_option_buttons .= '<button name="feature" value="user_logout">Logout</button>';
    $menu_option_buttons .= '&nbsp;&nbsp;';
    $menu_option_buttons .= '<button name="feature" value="add_machine">Add Crypto Machine</button>';
    $menu_option_buttons .= '&nbsp;&nbsp;';
    $menu_option_buttons .= '<button name="feature" value="display_Crypto_details">Display Crypto Details</button>';
   }
   else
   {
    $menu_option_buttons .= '<button name="feature" value="user_login">Login</button>';
   }


   $form_target_file = APP_ROOT_PATH;
   $form_method = 'post';

   $this->menu_bar = <<< MENUBAR
<div id="navbar">
<form method="$form_method" action="$form_target_file">
$menu_option_buttons
</form>
</div>
MENUBAR;
  }

  private function createWebPageFooter()
  {
   $html_output = <<< HTML
</body>
</html>
HTML;
   $this->html_page_output .= $html_output;
  }
 }

