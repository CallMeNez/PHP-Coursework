<?php
/**
 * Created by PhpStorm.
 * User: cfi
 * Date: 08/04/14
 * Time: 11:42
 */

class BcryptWrapper
{
    public function __construct() {}

    public function __destruct() {}

    public static function hashPassword($validated_user_password)
    {
        $hashed_password = '';
        $bcrypt_algorithm = PASSWORD_DEFAULT;
        $bcrypt_options = array('cost' => 10);

        if ($validated_user_password != '')
        {
            $hashed_password = password_hash($validated_user_password, $bcrypt_algorithm, $bcrypt_options);
        }

        return $hashed_password;
    }

    public static function validatePassword($current_user_password, $stored_user_password_hash)
    {
        $user_authenticated = false;

        if (password_verify($current_user_password, $stored_user_password_hash))
        {
            $user_authenticated = true;
        }
        return $user_authenticated;
    }
} 