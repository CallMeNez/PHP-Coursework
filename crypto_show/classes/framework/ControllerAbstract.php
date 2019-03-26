<?php
/**
 * ControllerAbstract.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

abstract class ControllerAbstract
{
    protected $html_output;

    public final function __construct()
    {
        $this->html_output = '';
    }

    public final function __destruct(){}

    public function getHtmlOutput()
    {
        return $this->html_output;
    }

    abstract protected function createHtmlOutput();
}
