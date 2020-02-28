<?php
/**

Ez a fálj biztosítja a kapcsolatot az adatbázissal.

*/
class Connect{

private $servername = "localhost";
private $username = "root";
private $password = "";
private $database = "alapdb";
public $conn;

public function getConnection(){

    try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->exec("set names utf8");
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>