<?php
// Establish and manage database connection using PDO

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, DBUSER, DBPASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        // $stmt->bindValue(':limit', $params['limit'], PDO::PARAM_INT);
        // $stmt->bindValue(':offset', $params['offset'], PDO::PARAM_INT);
        //$stmt->execute();
        //$stmt->execute([$limit, $offset]);
        
        if (!empty($params) && is_array($params)) { 
            $stmt->execute($params); // Ensure $params is an array
        } else {
            $stmt->execute();
        }
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $stmt = $this->pdo->prepare($sql);
        // $stmt->execute($params);
    
        return $stmt; // Always return PDOStatement
    }
    

    public function getRow($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    //Add transaction support
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}
