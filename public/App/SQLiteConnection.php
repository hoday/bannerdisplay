<?php

namespace App;

/**
 * SQLite connnection
 */
class SQLiteConnection {

  /**
   * PDO instance
   * @var type
   */
  private static $instance = NULL;

  private function __construct() {}

  private function __clone() {}

  /**
   * return in instance of the PDO object that connects to the SQLite database
   * @return \PDO
   */
  public static function getInstance() {
    if (self::$instance == null) {
      $dbFile = "sqlite:" . Config::PATH_TO_SQLITE_FILE;
      //$pdo_options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
      try {
        self::$instance = new \PDO($dbFile);
      } catch (\PDOException $e) {
        echo "Database connection error";
        var_dump($e);
      }
    }
    return self::$instance;
  }
}
