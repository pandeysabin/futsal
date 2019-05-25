<?php
/**Created by Pandey*/

class RememberBrowser extends DatabaseConnection {
    private $pdo;
    private $sql;
    private $q;
    private $userIp;

    public function __construct() {
        echo 'wakeful';
        $this->userIp = $_SERVER["REMOTE_ADDR"];
        $this->ipcheck();
    }

    public function ipCheck() {
        $this->pdo = $this->getPdo();
        try {
            $this->sql = 'SELECT `ip` FROM `hitsIp`';
            $this->q =  $this->pdo->prepare($this->sql);
            $this->q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Cannot fetch the date'. $e->getMessage());
        }
    }
}