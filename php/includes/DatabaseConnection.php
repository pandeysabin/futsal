<?php
    class DatabaseConnection {
        private $host;
        private $dbUser;
        private $password;
        private $dbName;
        private $charset;
        private $pdo;

        public function __construct() {
            $this->host = 'localhost';
            $this->dbUser = 'root';
            $this->password = '';
            $this->dbName = 'php_futsal';
            $this->charset = 'utf8';

            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName.';charset='.$this->charset;
            try {
                $this->pdo = new PDO($dsn, $this->dbUser, $this->password);
            } catch (PDOException $e) {
                die('Could connect to the database. '. $e->getMessage());
            }
        }

        /**
         * @return PDO
         */
        public function getPdo()
        {
            return $this->pdo;
        }
    }



    new DatabaseConnection();
