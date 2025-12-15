<?php

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Logger.php';

class Database
{
    private static $instance = null;
    private $pdo = null;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        try {
            $config = Config::db();
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
            Logger::info('Database connection established');
        } catch (PDOException $e) {
            Logger::error('Database connection failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get singleton instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get PDO connection
     */
    public function getConnection()
    {
        return $this->pdo;
    }

    /**
     * Execute a query and return results
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Logger::error('Database query failed', [
                'sql' => $sql,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Execute a query and return single row
     */
    public function queryOne($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            Logger::error('Database query failed', [
                'sql' => $sql,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Execute a query (INSERT, UPDATE, DELETE)
     */
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            return [
                'success' => $result,
                'rowCount' => $stmt->rowCount(),
                'lastInsertId' => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            Logger::error('Database execute failed', [
                'sql' => $sql,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->pdo->rollBack();
    }
}

