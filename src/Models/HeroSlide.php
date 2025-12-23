<?php

namespace App\Models;

class HeroSlide extends BaseModel
{
    protected string $table = 'hero_slides';
    
    /**
     * Get all active slides ordered by slide_order
     */
    public function getActiveSlides(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY slide_order ASC";
        return $this->query($sql);
    }
    
    /**
     * Get all slides for admin (including inactive)
     */
    public function getAllSlides(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY slide_order ASC, created_at DESC";
        return $this->query($sql);
    }
    
    /**
     * Update slide order
     */
    public function updateOrder(int $id, int $order): bool
    {
        return $this->update($id, ['slide_order' => $order]);
    }
    
    /**
     * Toggle slide active status
     */
    public function toggleActive(int $id): bool
    {
        $slide = $this->findById($id);
        if (!$slide) {
            return false;
        }
        
        $newStatus = $slide['is_active'] == 1 ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
