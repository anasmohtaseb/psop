<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Role Model
 */
class Role extends BaseModel
{
    protected string $table = 'roles';

    /**
     * Find role by name
     */
    public function findByName(string $name): ?array
    {
        return $this->findOne(['role_name' => $name]);
    }

    /**
     * Get all roles
     */
    public function getAllRoles(): array
    {
        return $this->findAll();
    }
}
