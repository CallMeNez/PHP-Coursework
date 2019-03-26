<?php
/**
 * Router.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class Router
{
    private $feature_in;
    private $feature;
    private $html_output;
    private $output;

    public function __construct()
    {
        $this->feature_in = '';
        $this->feature = '';
        $this->output = '';
        $this->html_output = '';
    }

    public function __destruct(){}

    public function routing()
    {
        $this->setFeatureName();
        $this->mapFeatureName();
        $this->selectController();
        $this->processOutput();
    }

    public function getHtmlOutput()
    {
        return $this->html_output;
    }

    private function setFeatureName()
    {
        if (isset($_POST['feature']))
        {
            $feature_in = $_POST['feature'];
        }
        else
        {
            $feature_in = 'index';
        }

        $this->feature_in = $feature_in;
    }

    private function mapFeatureName()
    {
        $feature_exists = false;
        // map the passed module name to an internal application feature name
        $features = array(
            'index' => 'landing-page',
            'user_register' => 'user-register-form',
            'process_new_user_details' => 'user-register-process',
            'user_login' => 'user-login-form',
            'process_login' => 'user-login-process',
            'user_logout' => 'user-logout-process',
            'add_machine' => 'user-add-cm-form',
            'process_create_machine' => 'user-add-cm-process'
        );

        if (array_key_exists($this->feature_in, $features))
        {
            $this->feature = $features[$this->feature_in];
            $feature_exists =  true;
        }
        else
        {
            $this->feature = 'feature-error';
        }
        return $feature_exists;
    }

    public function selectController()
    {
        switch ($this->feature)
        {
            case 'user-register-form':
                $controller = Factory::buildObject('UserRegisterFormController');
                break;
            case 'user-register-process':
                $controller = Factory::buildObject('UserRegisterProcessController');
                break;
            case 'user-login-form':
                $controller = Factory::buildObject('UserLoginFormController');
                break;
            case 'user-login-process':
                $controller = Factory::buildObject('UserLoginProcessController');
                break;
            case 'user-logout-process':
                $controller = Factory::buildObject('UserLogoutProcessController');
                break;
            case 'display-crypto-details':
                $controller = Factory::buildObject('DisplayCryptoDetailsController');
                break;
            case 'feature-error':
                $controller = Factory::buildObject('ErrorController');
                $controller->setErrorType('feature-not-found-error');
                break;
            case 'user-add-cm-form':
                $controller = Factory::buildObject('UserCryptoMachineFormController');
                break;
            case 'user-add-cm-process':
                $controller = Factory::buildObject('UserCryptoMachineProcessController');
                break;
            case 'landing-page':
            default:
            $controller = Factory::buildObject('IndexController');
                break;
        }
        $controller->createHtmlOutput();
        $this->output = $controller->getHtmlOutput();
    }

    private function processOutput()
    {
        $process_output = Factory::buildObject('ProcessOutput');
        $this->html_output = $compressed_output = $process_output->assembleOutput($this->output);
    }
}
