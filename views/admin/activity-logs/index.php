<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل النشاطات - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <i class="bi bi-activity me-2"></i>
                سجل النشاطات
            </h1>
            <a href="<?= $this->url('/admin/activity-logs/export?' . http_build_query($filters)) ?>" 
               class="btn btn-success">
                <i class="bi bi-download me-1"></i>
                تصدير CSV
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">إجمالي النشاطات</h6>
                                <h3 class="mb-0"><?= number_format((int)($statistics['total_activities'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-activity fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">اليوم</h6>
                                <h3 class="mb-0 text-success"><?= number_format((int)($statistics['today_count'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-calendar-day fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">هذا الأسبوع</h6>
                                <h3 class="mb-0 text-info"><?= number_format((int)($statistics['week_count'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-info">
                                <i class="bi bi-calendar-week fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">مستخدمون نشطون</h6>
                                <h3 class="mb-0 text-warning"><?= number_format((int)($statistics['unique_users'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">الإجراء</label>
                        <select name="action" class="form-select">
                            <option value="">جميع الإجراءات</option>
                            <option value="login" <?= ($filters['action'] ?? '') === 'login' ? 'selected' : '' ?>>تسجيل دخول</option>
                            <option value="logout" <?= ($filters['action'] ?? '') === 'logout' ? 'selected' : '' ?>>تسجيل خروج</option>
                            <option value="create" <?= ($filters['action'] ?? '') === 'create' ? 'selected' : '' ?>>إنشاء</option>
                            <option value="update" <?= ($filters['action'] ?? '') === 'update' ? 'selected' : '' ?>>تعديل</option>
                            <option value="delete" <?= ($filters['action'] ?? '') === 'delete' ? 'selected' : '' ?>>حذف</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">نوع الكيان</label>
                        <select name="entity_type" class="form-select">
                            <option value="">الكل</option>
                            <option value="user" <?= ($filters['entity_type'] ?? '') === 'user' ? 'selected' : '' ?>>مستخدم</option>
                            <option value="competition" <?= ($filters['entity_type'] ?? '') === 'competition' ? 'selected' : '' ?>>مسابقة</option>
                            <option value="registration" <?= ($filters['entity_type'] ?? '') === 'registration' ? 'selected' : '' ?>>تسجيل</option>
                            <option value="subscription" <?= ($filters['entity_type'] ?? '') === 'subscription' ? 'selected' : '' ?>>اشتراك</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="date_from" class="form-control" 
                               value="<?= $this->e($filters['date_from'] ?? '') ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="date_to" class="form-control" 
                               value="<?= $this->e($filters['date_to'] ?? '') ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="اسم المستخدم أو الوصف"
                               value="<?= $this->e($filters['search'] ?? '') ?>">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>المستخدم</th>
                                <th>الإجراء</th>
                                <th>الوصف</th>
                                <th>عنوان IP</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    لا توجد نشاطات
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php if ($log['user_id']): ?>
                                    <div>
                                        <strong><?= $this->e($log['user_name'] ?? 'Unknown') ?></strong>
                                    </div>
                                    <small class="text-muted"><?= $this->e($log['user_email'] ?? '') ?></small>
                                    <br>
                                    <span class="badge bg-secondary"><?= $this->e($log['user_type']) ?></span>
                                    <?php else: ?>
                                    <span class="text-muted">ضيف</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $actionColors = [
                                        'login' => 'success',
                                        'logout' => 'secondary',
                                        'create' => 'primary',
                                        'update' => 'info',
                                        'delete' => 'danger'
                                    ];
                                    $color = $actionColors[$log['action']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $color ?>">
                                        <?= $this->e($log['action']) ?>
                                    </span>
                                    <?php if ($log['entity_type']): ?>
                                    <br>
                                    <small class="text-muted">
                                        <?= $this->e($log['entity_type']) ?>
                                        <?php if ($log['entity_id']): ?>
                                        #<?= $log['entity_id'] ?>
                                        <?php endif; ?>
                                    </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($log['description']): ?>
                                    <?= $this->e($log['description']) ?>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code class="small"><?= $this->e($log['ip_address'] ?? '-') ?></code>
                                </td>
                                <td>
                                    <small><?= date('Y-m-d H:i', strtotime($log['created_at'])) ?></small>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
