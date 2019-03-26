<?php
/**
 * settings.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

define ('DIRSEP', DIRECTORY_SEPARATOR);
define ('URLSEP', '/');

$class_path = realpath(dirname(__FILE__)) . DIRSEP . 'classes'. DIRSEP;

$app_root_path = $_SERVER['PHP_SELF'];
$document_root = $_SERVER['HTTP_HOST'];
$app_root_path = explode(URLSEP, $app_root_path, -1);
$app_root_path = implode(URLSEP, $app_root_path) . URLSEP;
$app_root_path = 'http://' . $document_root . $app_root_path;

$application_name = 'Cryptographic Machine Show';
$media_path = $app_root_path . 'media' . URLSEP;
$crypto_machine_pics_path = $media_path . 'crypto_machine_pics' . URLSEP;
$css_path = $app_root_path . 'css' . URLSEP;
$css_file_name = 'crypto_show.css';

define ('CLASS_PATH', $class_path);
define ('APP_ROOT_PATH', $app_root_path);
define ('APP_NAME', $application_name);
define ('MEDIA_PATH', $media_path);
define ('CRYPTO_MACHINE_PICS_PATH', $crypto_machine_pics_path);
define ('CSS_PATH' , $css_path);
define ('CSS_FILE_NAME', $css_file_name);

function getPdoDatabaseConnectionDetails()
{
    $rdbms = 'mysql';
    $host = 'localhost';
    $port = '3306';
    $charset = 'utf8mb4';
    $db_name = 'cryptoshow_db';
    $pdo_dsn = $rdbms . ':host=' . $host. ';port=' . $port . ';dbname=' . $db_name . ';charset=' . $charset;

    $user_name = 'cryptoshowuser';
    $user_password = 'cryptoshowpass';
    $db_connect_details['pdo_dsn'] = $pdo_dsn;
    $db_connect_details['pdo_user_name'] = $user_name;
    $db_connect_details['pdo_user_password'] = $user_password;
    return $db_connect_details;
}
