<?php
class Database {
 private function host() {
  return 'localhost:3306';
 }

 private function user() {
  return "root";
 }

 private function password() {
  return "";
 }

 private function dbname() {
  return "ierek";
 }

 private $dbh;
 private $error;

 public function __construct() {
  $dsn = 'mysql:host=' . $this->host() . ';dbname=' . $this->dbname();

  $options = array(
   PDO::ATTR_PERSISTENT    => true,
   PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
  );   

  try{
   $this->dbh = new PDO($dsn, $this->user(), $this->password(), $options);
   return 'Success';
  }

  catch(PDOException $e){
   $this->error = $e->getMessage();
   return $e;
   // return false;
  }
 }
}

return new Database;
?>