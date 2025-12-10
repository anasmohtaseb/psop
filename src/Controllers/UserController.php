<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    private User $userModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->userModel = new User($config);
    }

    /**
     * Display list of all users (admin only)
     */
    public function index(): void
    {
        $this->requireRole('admin');

        // Get filter parameters
        $filters = [
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        // Get users with filters
        $users = $this->userModel->searchUsers($filters);

        // Get statistics
        $stats = $this->userModel->getStatistics();

        $this->render('admin/users/index', [
            'users' => $users,
            'totalUsers' => $stats['total'],
            'activeUsers' => $stats['active'],
            'pendingUsers' => $stats['pending'],
            'filters' => $filters
        ], 'dashboard');
    }

    /**
     * Show create user form
     */
    public function create(): void
    {
        $this->requireRole('admin');

        $this->render('admin/users/create', [
            'csrf_token' => $this->generateCsrfToken()
        ], 'dashboard');
    }

    /**
     * Store new user
     */
    public function store(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        // Validate input
        $errors = [];

        if (empty($_POST['name'])) {
            $errors['name'] = 'الاسم مطلوب';
        }

        if (empty($_POST['email'])) {
            $errors['email'] = 'البريد الإلكتروني مطلوب';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'البريد الإلكتروني غير صحيح';
        } else {
            // Check if email already exists
            $existingUser = $this->userModel->findOne(['email' => $_POST['email']]);
            if ($existingUser) {
                $errors['email'] = 'البريد الإلكتروني مستخدم بالفعل';
            }
        }

        if (empty($_POST['password'])) {
            $errors['password'] = 'كلمة المرور مطلوبة';
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password'] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        }

        if (empty($_POST['type'])) {
            $errors['type'] = 'نوع المستخدم مطلوب';
        } elseif (!in_array($_POST['type'], ['student', 'school_coordinator', 'trainer', 'admin', 'competition_manager'])) {
            $errors['type'] = 'نوع المستخدم غير صحيح';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/users/create');
            return;
        }

        // Create user
        $userId = $this->userModel->create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'phone' => $_POST['phone'] ?? null,
            'type' => $_POST['type'],
            'status' => $_POST['status'] ?? 'active'
        ]);

        // Assign role (same as type)
        $role = $this->userModel->getRoleByName($_POST['type']);
        if ($role) {
            $this->userModel->assignRole((int)$userId, (int)$role['id']);
        }

        $this->setFlash('success', 'تم إضافة المستخدم بنجاح');
        $this->redirect('/admin/users');
    }

    /**
     * Show edit user form
     */
    public function edit(string $id): void
    {
        $this->requireRole('admin');

        $user = $this->userModel->findById((int)$id);

        if (!$user) {
            $this->setFlash('error', 'المستخدم غير موجود');
            $this->redirect('/admin/users');
            return;
        }

        $this->render('admin/users/edit', [
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken()
        ], 'dashboard');
    }

    /**
     * Update user
     */
    public function update(string $id): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $user = $this->userModel->findById((int)$id);

        if (!$user) {
            $this->setFlash('error', 'المستخدم غير موجود');
            $this->redirect('/admin/users');
            return;
        }

        // Validate input
        $errors = [];

        if (empty($_POST['name'])) {
            $errors['name'] = 'الاسم مطلوب';
        }

        if (empty($_POST['email'])) {
            $errors['email'] = 'البريد الإلكتروني مطلوب';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'البريد الإلكتروني غير صحيح';
        } else {
            // Check if email already exists for another user
            $existingUser = $this->userModel->findOne(['email' => $_POST['email']]);
            if ($existingUser && $existingUser['id'] != $id) {
                $errors['email'] = 'البريد الإلكتروني مستخدم بالفعل';
            }
        }

        if (empty($_POST['type'])) {
            $errors['type'] = 'نوع المستخدم مطلوب';
        } elseif (!in_array($_POST['type'], ['student', 'school_coordinator', 'trainer', 'admin', 'competition_manager'])) {
            $errors['type'] = 'نوع المستخدم غير صحيح';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/users/' . $id . '/edit');
            return;
        }

        // Update user data
        $updateData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'type' => $_POST['type'],
            'status' => $_POST['status'] ?? 'active'
        ];

        // Update password if provided
        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 6) {
                $_SESSION['errors'] = ['password' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل'];
                $_SESSION['old'] = $_POST;
                $this->redirect('/admin/users/' . $id . '/edit');
                return;
            }
            $updateData['password_hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $this->userModel->update((int)$id, $updateData);

        // Update role if type changed
        if ($user['type'] !== $_POST['type']) {
            // Remove old roles
            $this->userModel->removeAllRoles((int)$id);
            
            // Add new role
            $role = $this->userModel->getRoleByName($_POST['type']);
            if ($role) {
                $this->userModel->assignRole((int)$id, (int)$role['id']);
            }
        }

        $this->setFlash('success', 'تم تحديث المستخدم بنجاح');
        $this->redirect('/admin/users');
    }

    /**
     * Delete user
     */
    public function delete(string $id): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        // Prevent deleting yourself
        if ($this->auth->user()['id'] == $id) {
            $this->setFlash('error', 'لا يمكنك حذف حسابك الخاص');
            $this->redirect('/admin/users');
            return;
        }

        $user = $this->userModel->findById((int)$id);

        if (!$user) {
            $this->setFlash('error', 'المستخدم غير موجود');
            $this->redirect('/admin/users');
            return;
        }

        $this->userModel->delete((int)$id);
        $this->setFlash('success', 'تم حذف المستخدم بنجاح');
        $this->redirect('/admin/users');
    }
}
