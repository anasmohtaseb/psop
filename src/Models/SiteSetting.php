<?php

namespace App\Models;

class SiteSetting extends BaseModel
{
    protected string $table = 'site_settings';
    
    /**
     * Get setting by key
     */
    public function getByKey(string $key): ?array
    {
        return $this->findOne(['setting_key' => $key]);
    }
    
    /**
     * Get setting value by key
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->getByKey($key);
        return $setting ? $setting['setting_value'] : $default;
    }
    
    /**
     * Update setting value
     */
    public function updateByKey(string $key, $value): bool
    {
        $setting = $this->getByKey($key);
        if (!$setting) {
            return false;
        }
        
        return $this->update($setting['id'], ['setting_value' => $value]);
    }
    
    /**
     * Get settings by group
     */
    public function getByGroup(string $group): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE setting_group = ? ORDER BY display_order ASC";
        return $this->query($sql, [$group]);
    }
    
    /**
     * Get all settings grouped
     */
    public function getAllGrouped(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY setting_group, display_order ASC";
        $settings = $this->query($sql);
        
        $grouped = [];
        foreach ($settings as $setting) {
            $group = $setting['setting_group'];
            if (!isset($grouped[$group])) {
                $grouped[$group] = [];
            }
            $grouped[$group][] = $setting;
        }
        
        return $grouped;
    }
    
    /**
     * Get all settings as key-value array
     */
    public function getAllAsArray(): array
    {
        $sql = "SELECT setting_key, setting_value FROM {$this->table}";
        $settings = $this->query($sql);
        
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        
        return $result;
    }
}
