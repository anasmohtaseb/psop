<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Simple Validator
 * Provides validation helper methods
 */
class Validator
{
    private array $errors = [];
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validate required field
     */
    public function required(string $field, string $message = null): self
    {
        if (empty($this->data[$field])) {
            $this->errors[$field][] = $message ?? "حقل {$field} مطلوب";
        }
        return $this;
    }

    /**
     * Validate email format
     */
    public function email(string $field, string $message = null): self
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message ?? "البريد الإلكتروني غير صحيح";
        }
        return $this;
    }

    /**
     * Validate minimum length
     */
    public function min(string $field, int $length, string $message = null): self
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field][] = $message ?? "يجب أن يكون {$field} على الأقل {$length} حرف";
        }
        return $this;
    }

    /**
     * Validate maximum length
     */
    public function max(string $field, int $length, string $message = null): self
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field][] = $message ?? "يجب أن لا يتجاوز {$field} {$length} حرف";
        }
        return $this;
    }

    /**
     * Validate that field matches another field
     */
    public function matches(string $field, string $matchField, string $message = null): self
    {
        if (!empty($this->data[$field]) && $this->data[$field] !== ($this->data[$matchField] ?? '')) {
            $this->errors[$field][] = $message ?? "الحقلان غير متطابقان";
        }
        return $this;
    }

    /**
     * Validate unique value in database
     */
    public function unique(string $field, \PDO $db, string $table, string $column, ?int $exceptId = null, string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
            $params = [$this->data[$field]];
            
            if ($exceptId !== null) {
                $sql .= " AND id != ?";
                $params[] = $exceptId;
            }
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            
            if ($stmt->fetchColumn() > 0) {
                $this->errors[$field][] = $message ?? "هذه القيمة مستخدمة بالفعل";
            }
        }
        return $this;
    }

    /**
     * Validate phone number format (Palestinian format)
     */
    public function phone(string $field, string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $phone = preg_replace('/[^0-9+]/', '', $this->data[$field]);
            if (!preg_match('/^(\+970|970|0)?5[0-9]{8}$/', $phone)) {
                $this->errors[$field][] = $message ?? "رقم الهاتف غير صحيح";
            }
        }
        return $this;
    }

    /**
     * Validate date format
     */
    public function date(string $field, string $format = 'Y-m-d', string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $date = \DateTime::createFromFormat($format, $this->data[$field]);
            if (!$date || $date->format($format) !== $this->data[$field]) {
                $this->errors[$field][] = $message ?? "التاريخ غير صحيح";
            }
        }
        return $this;
    }

    /**
     * Validate that value is in array
     */
    public function in(string $field, array $values, string $message = null): self
    {
        if (!empty($this->data[$field]) && !in_array($this->data[$field], $values)) {
            $this->errors[$field][] = $message ?? "القيمة المدخلة غير صحيحة";
        }
        return $this;
    }

    /**
     * Check if validation passed
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     */
    public function fails(): bool
    {
        return !$this->passes();
    }

    /**
     * Get all errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error for a field
     */
    public function firstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
