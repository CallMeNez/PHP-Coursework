<?php
/**
 * autoload.php
 *
 * register the autoload functionality.  When the application calls for a class to be instantiated,
 * the class definition file must first be located and loaded.
 *
 * A closure is used to supply the logic
 *
 * for more details, see https://secure.php.net/manual/en/function.spl-autoload-register.php
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright CFI, De Montfort University
 *
 * @package crypto-show
 */

spl_autoload_register(function ($class_name)
{
    $file_path_and_name = '';
    $directories = [];

    $file_name = $class_name . '.php';

    $directories = array_diff(scandir(CLASS_PATH), array('..', '.'));

    foreach ($directories as $directory)
    {
        $file_path_and_name = CLASS_PATH . $directory . DIRSEP . $file_name;

        if (file_exists($file_path_and_name))
        {
            require_once $file_path_and_name;
            break;
        }
    }
});
