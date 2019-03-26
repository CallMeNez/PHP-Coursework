<?php declare(strict_types=1); // strict mode
/**
 * bootstrap.php
 *
 * Class definition files are grouped together by type, ie all Controller classes are in the controller directory.
 *
 * The autoload script creates an array of available directories,
 * then iterates through the array of the directory names, looking for the required class definition file.
 * If the correct file is find, it is loaded and the class is instantiated.
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

$session_started = session_start();

if ($session_started)
{
    include_once 'settings.php';
    include_once 'autoload.php';

//    settings::definitions();
//    FrameworkFactory::makeRouter();


    $router = Factory::buildObject('Router');
    $router->routing();
    $html_output = $router->getHtmlOutput();

    echo $html_output;
}
