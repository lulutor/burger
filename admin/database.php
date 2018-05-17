<?php

  class Database {
    private static $dbHost = "localhost";
    private static $dbname = "burger code";
    private static $dbUser = "root";
    private static $dbUserPassword = "arinfo";

    private static $connection = null;

    public static function connect() {
      try {
        #$connection = new PDO("mysql:host = localhost; dbname=burger_code","root","arinfo"); ==> ce a qoui sa ressemeble sans déclaration de variables
        self::$connection = new PDO("mysql:host =" . self::$dbHost . ";dbname=" . self::$dbname,self::$dbUser,self::$dbUserPassword);
      }
      catch (PDOException $e) {
        die($e->getMessage());
      }
      return self::$connection;
    }

    public static function disconnect() {
      self::$connection = null;
    }

  }

Database::connect();


?>
