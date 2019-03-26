<?php
/**
 * Validate.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package crypto-show
 */

class Validate
{

    public function __construct() {}

    public function __destruct() {}

    public function validateString($datum_name, $tainted, $min_length, $max_length)
    {
        $validated_string = false;
        if (!empty($tainted[$datum_name]))
        {
            $string_to_check = $tainted[$datum_name];
            $sanitised_string = filter_var($string_to_check, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            $sanitised_string_length = strlen($sanitised_string);
            if ($min_length <= $sanitised_string_length && $sanitised_string_length <= $max_length)
            {
                $validated_string = $sanitised_string;
            }
        }
        return $validated_string;
    }

    public function validateEmail($datum_name, $tainted, $datum_name_confirm, $maximum_email_length)
    {
        $minimum_email_length = 0;
        $validated_email_to_return = false;

        if (!empty($tainted[$datum_name]) && !empty($tainted[$datum_name_confirm]))
        {
            $email_to_check = $tainted[$datum_name];
            $email_confirm_to_check = $tainted[$datum_name_confirm];

            $sanitised_email = filter_var($email_to_check, FILTER_SANITIZE_EMAIL);
            $validated_email = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);

            $validated_email_length = strlen($validated_email);
            if ($minimum_email_length <= $validated_email_length && $validated_email_length <= $maximum_email_length)
            {
                if (strcmp($validated_email, $email_confirm_to_check) == 0)
                {
                    $validated_email_to_return = $sanitised_email;
                }
            }
        }
        return $validated_email_to_return;
    }

    public function checkForError($cleaned)
    {
        $input_error = false;
        foreach ($cleaned as $field_to_check)
        {
            if ($field_to_check === false)
            {
                $input_error = true;
                break;
            }

        }
        return $input_error;
    }
}
