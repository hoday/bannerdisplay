<?php

namespace App;

/**
 * SQLite Create Table Demo
 */
class SQLiteCreateTable {

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * connect to the SQLite database
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * create tables
     */
    public function createTables() {
        $commands = ['CREATE TABLE IF NOT EXISTS banners (
                        banner_id   INTEGER PRIMARY KEY,
                        banner_name TEXT NOT NULL UNIQUE,
                        banner_path TEXT,
                        start_date TEXT,
                        end_date TEXT
                      )',
            'CREATE TABLE IF NOT EXISTS banner_allowed_ips (
                    banner_id INTEGER,
                    ip_id  INTEGER,
                    FOREIGN KEY (ip_id)
                    REFERENCES allowed_ips(ip_id) ON UPDATE CASCADE
                                                  ON DELETE CASCADE
                  )',
            'CREATE TABLE IF NOT EXISTS allowed_ips (
                    ip_id INTEGER PRIMARY KEY,
                    ip  TEXT UNIQUE
                  )',
                ];
        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    /**
     * get the table list in the database
     */
    public function getTableList() {

        $stmt = $this->pdo->query("SELECT name
                                   FROM sqlite_master
                                   WHERE type = 'table'
                                   ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }

        return $tables;
    }

}
