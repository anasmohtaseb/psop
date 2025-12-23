<?php

namespace App\Models;

class ContactMessage extends BaseModel
{
    protected string $table = 'contact_messages';

    /**
     * Get all messages with pagination
     */
    public function getAllMessages(int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ? OFFSET ?";
        return $this->query($sql, [$limit, $offset]);
    }

    /**
     * Get messages by status
     */
    public function getByStatus(string $status, int $limit = 50): array
    {
        return $this->findAll(['status' => $status], $limit);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, ['status' => 'read']);
    }

    /**
     * Mark message as replied
     */
    public function markAsReplied(int $id): bool
    {
        return $this->update($id, ['status' => 'replied']);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'new'";
        $result = $this->queryOne($sql);
        return (int)($result['count'] ?? 0);
    }

    /**
     * Search messages
     */
    public function search(string $query, int $limit = 50): array
    {
        $searchTerm = "%{$query}%";
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?
                ORDER BY created_at DESC LIMIT ?";
        return $this->query($sql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit]);
    }
}
