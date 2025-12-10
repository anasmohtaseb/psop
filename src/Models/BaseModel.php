<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Base Model
 * Provides common database functionality for all models
 */
abstract class BaseModel
{
    protected PDO $db;
    protected array $config;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct(array $config)
    {
        $this->config = $config;
        
        // Load database connection function and get PDO instance
        require_once $config['paths']['root'] . '/config/database.php';
        $this->db = getDatabase($config);
    }

    /**
     * Find record by ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find all records with optional filtering
     */
    public function findAll(array $filters = [], int $limit = 100, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $field => $value) {
                $conditions[] = "{$field} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Find one record by conditions
     */
    public function findOne(array $conditions): ?array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $field => $value) {
                $whereClauses[] = "{$field} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }
        
        $sql .= " LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new record
     */
    public function create(array $data): int
    {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return (int)$this->db->lastInsertId();
    }

    /**
     * Update a record
     */
    public function update(int $id, array $data): bool
    {
        $fields = array_keys($data);
        $setParts = array_map(fn($field) => "{$field} = ?", $fields);
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . 
               " WHERE {$this->primaryKey} = ?";
        
        $params = array_values($data);
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete a record
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Count records with optional filtering
     */
    public function count(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $params = [];
        
        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $field => $value) {
                $conditions[] = "{$field} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Execute custom query
     */
    protected function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute custom query and return single row
     */
    protected function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
