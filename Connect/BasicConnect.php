<?php
/**

Ez a fálj biztosítja, hogy az adatbázist létretudjuk hozni

*/
class BasicConnect{

private $servername = "localhost";
private $username = "root";
private $password = "";
public $conn;

public function getBasicConnection(){

    try {
        $this->conn = new PDO("mysql:host=$this->servername", $this->username, $this->password);

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