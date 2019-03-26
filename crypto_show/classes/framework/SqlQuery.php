<?php
 /**
  * SqlQuery.php
  *
  * @author CF Ingrams - cfi@dmu.ac.uk
  * @copyright De Montfort University
  *
  * @package crypto-show
  */

 class SqlQuery
 {

  public function __construct(){}

  public function __destruct(){}

  public static function queryGetCryptoMachineNames()
  {
   $sql_query_string  = 'SELECT Crypto_name';
   $sql_query_string .= ' FROM Crypto';
   return $sql_query_string;
  }

  public static function queryGetRegisteredUserNames()
  {
   $sql_query_string  = 'SELECT user_name';
   $sql_query_string .= ' FROM registered_user';
   return $sql_query_string;
  }

  public static function queryStoreNewUserDetails()
  {
   $sql_query_string  = 'INSERT INTO registered_user';
   $sql_query_string .= ' SET';
   $sql_query_string .= ' user_nickname = :usernickname,';
   $sql_query_string .= ' user_name = :username,';
   $sql_query_string .= ' user_email = :useremail,';
   $sql_query_string .= ' user_hashed_password = :userhashedpassword,';
   $sql_query_string .= ' user_machine_count = :usermachinecount,';
   $sql_query_string .= ' user_registered_timestamp = :userregisteredtimestamp';
   return $sql_query_string;
  }

  public static function queryAuthenticateUser()
  {
   $sql_query_string  = 'SELECT user_hashed_password';
   $sql_query_string .= ' FROM registered_user';
   $sql_query_string .= ' WHERE user_nickname = :usernickname';
   $sql_query_string .= ' LIMIT 1';
   return $sql_query_string;
  }

  public static function queryFetchUserDetails()
  {
   $sql_query_string  = 'SELECT user_id, user_name, user_email, user_machine_count, user_registered_timestamp';
   $sql_query_string .= ' FROM registered_user';
   $sql_query_string .= ' WHERE user_nickname = :usernickname';
   $sql_query_string .= ' LIMIT 1';
   return $sql_query_string;
  }
  public static function queryEditMachineCount($machine_count, $user_nickname)
 {
     $sql_query_string = 'UPDATE `cryptoshow_db.registered_user` <br>';
     $sql_query_string .= "SET `machine_count`=$machine_count <br>";
     $sql_query_string .= "WHERE `user_nickname=$user_nickname";
     return $sql_query_string;
 }
  public static function queryStoreCryptoMachineDetails()
  {
      $sql_query_string = 'INSERT INTO crypto_machine';
      $sql_query_string .= ' SET';
      $sql_query_string .= ' crypto_machine_name = :cmname,';
      $sql_query_string .= ' crypto_machine_model = :cmmodel,';
      $sql_query_string .= ' crypto_machine_description = :cmdesc,';
      $sql_query_string .= ' crypto_machine_country_of_origin = :cmcoo,';
      $sql_query_string .= ' crypto_machine_image = :cmimg';
      return $sql_query_string;
  }

  public static function queryGetCryptoMachineDetails()
  {
   $sql_query_string  = " use cryptoshow_db; <br>";
   $sql_query_string .= "`select crypto_machine_name`, `crypto_machine_model`, `crypto_machine_description`, ";
   $sql_query_string .= "`crypto_machine_image_name`, `crypto_machine_country_of_origin` ";
   $sql_query_string .= "FROM `crypto_machine`";
   return $sql_query_string;
  }

  public static function queryLogErrorMessage()
  {
   $sql_query_string  = 'INSERT INTO cryptoshow_error_log';
   $sql_query_string .= ' SET log_message = :logmessage';
   return $sql_query_string;
  }
 }

