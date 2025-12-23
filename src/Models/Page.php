<?php

namespace App\Models;

class Page extends BaseModel
{
    protected string $table = 'pages';
    
    /**
     * الحصول على صفحة بواسطة المفتاح
     */
    public function findByKey(string $key): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE page_key = :key AND is_active = 1 LIMIT 1";
        return $this->queryOne($query, ['key' => $key]);
    }
    
    /**
     * الحصول على أقسام صفحة معينة
     */
    public function getSections(int $pageId): array
    {
        $query = "SELECT * FROM page_sections 
                  WHERE page_id = :page_id AND is_active = 1 
                  ORDER BY section_order ASC";
        return $this->query($query, ['page_id' => $pageId]);
    }
    
    /**
     * الحصول على إحصائيات صفحة معينة
     */
    public function getStats(int $pageId): array
    {
        $query = "SELECT * FROM page_stats 
                  WHERE page_id = :page_id AND is_active = 1 
                  ORDER BY stat_order ASC";
        return $this->query($query, ['page_id' => $pageId]);
    }
    
    /**
     * الحصول على قسم محدد
     */
    public function getSection(int $pageId, string $sectionKey): ?array
    {
        $query = "SELECT * FROM page_sections 
                  WHERE page_id = :page_id AND section_key = :key AND is_active = 1 
                  LIMIT 1";
        return $this->queryOne($query, [
            'page_id' => $pageId,
            'key' => $sectionKey
        ]);
    }
    
    /**
     * الحصول على كامل محتوى الصفحة مع الأقسام والإحصائيات
     */
    public function getPageContent(string $pageKey): ?array
    {
        $page = $this->findByKey($pageKey);
        
        if (!$page) {
            return null;
        }
        
        $page['sections'] = $this->getSections($page['id']);
        $page['stats'] = $this->getStats($page['id']);
        
        // تنظيم الأقسام حسب النوع
        $page['sections_by_type'] = [];
        foreach ($page['sections'] as $section) {
            $type = $section['section_type'];
            if (!isset($page['sections_by_type'][$type])) {
                $page['sections_by_type'][$type] = [];
            }
            $page['sections_by_type'][$type][] = $section;
        }
        
        // تنظيم الأقسام حسب المفتاح
        $page['sections_by_key'] = [];
        foreach ($page['sections'] as $section) {
            $page['sections_by_key'][$section['section_key']] = $section;
        }
        
        return $page;
    }
    
    /**
     * تحديث قسم
     */
    public function updateSection(int $sectionId, array $data): bool
    {
        $allowedFields = [
            'section_title_ar', 'section_title_en', 
            'section_content_ar', 'section_content_en',
            'section_icon', 'section_order', 'is_active'
        ];
        
        $updates = [];
        $params = ['id' => $sectionId];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $query = "UPDATE page_sections SET " . implode(', ', $updates) . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error updating section: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * إنشاء قسم جديد
     */
    public function createSection(array $data): ?int
    {
        $requiredFields = ['page_id', 'section_key', 'section_type'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return null;
            }
        }
        
        $allowedFields = [
            'page_id', 'section_key', 'section_title_ar', 'section_title_en',
            'section_content_ar', 'section_content_en', 'section_icon',
            'section_order', 'section_type', 'is_active'
        ];
        
        $fields = [];
        $placeholders = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = $key;
                $placeholders[] = ":{$key}";
                $params[$key] = $value;
            }
        }
        
        $query = "INSERT INTO page_sections (" . implode(', ', $fields) . ") 
                  VALUES (" . implode(', ', $placeholders) . ")";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return (int)$this->db->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Error creating section: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * حذف قسم
     */
    public function deleteSection(int $sectionId): bool
    {
        $query = "DELETE FROM page_sections WHERE id = :id";
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $sectionId]);
        } catch (\PDOException $e) {
            error_log("Error deleting section: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * تحديث إحصائية
     */
    public function updateStat(int $statId, array $data): bool
    {
        $allowedFields = ['stat_label_ar', 'stat_label_en', 'stat_value', 'stat_order', 'is_active'];
        
        $updates = [];
        $params = ['id' => $statId];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $query = "UPDATE page_stats SET " . implode(', ', $updates) . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error updating stat: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * إنشاء إحصائية جديدة
     */
    public function createStat(array $data): ?int
    {
        $requiredFields = ['page_id', 'stat_label_ar', 'stat_value'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return null;
            }
        }
        
        $allowedFields = [
            'page_id', 'stat_label_ar', 'stat_label_en', 
            'stat_value', 'stat_order', 'is_active'
        ];
        
        $fields = [];
        $placeholders = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = $key;
                $placeholders[] = ":{$key}";
                $params[$key] = $value;
            }
        }
        
        $query = "INSERT INTO page_stats (" . implode(', ', $fields) . ") 
                  VALUES (" . implode(', ', $placeholders) . ")";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return (int)$this->db->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Error creating stat: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * حذف إحصائية
     */
    public function deleteStat(int $statId): bool
    {
        $query = "DELETE FROM page_stats WHERE id = :id";
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $statId]);
        } catch (\PDOException $e) {
            error_log("Error deleting stat: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * تحديث معلومات الصفحة الأساسية
     */
    public function updatePage(int $pageId, array $data): bool
    {
        $allowedFields = ['page_title_ar', 'page_title_en', 'meta_description', 'is_active'];
        
        $updates = [];
        $params = ['id' => $pageId];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $query = "UPDATE {$this->table} SET " . implode(', ', $updates) . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error updating page: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * الحصول على جميع الصفحات
     */
    public function getAllPages(): array
    {
        $query = "SELECT * FROM {$this->table} ORDER BY page_key ASC";
        return $this->query($query);
    }
}
