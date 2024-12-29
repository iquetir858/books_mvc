<?php

//Clase que realiza toda la conexión a la base de datos para obtener
//  los datos (en este caso deberá ser de los libros) (
//La tabla se define ne ContactsGateaway
class Database
{
    private static $dbName = 'crud_mvc';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'root';

    private static $conn = null;

    public function __construct()
    {
        // die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$conn) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function disconnect()
    {
        self::$conn = null;
    }
}

?>
