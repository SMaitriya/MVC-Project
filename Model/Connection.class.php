<?php
class Connection {
 private $host;
 private $dbname;
 private $username;
 private $password;
 private $db;
 public function __construct() {
 $this->host = 'localhost';
 $this->dbname = 'mvctrain';
 $this->username = 'root';
 $this->password = '';
 try
 {
 $this->db = new PDO('mysql:host=' . $this->host . ';dbname='
. $this->dbname . ';charset=utf8', $this->username, $this->password);
 }
 catch(PDOException $e)
 {
 echo $e->getMessage();
 }
 }
 public function getDb() {
 return $this->db;
 }
}