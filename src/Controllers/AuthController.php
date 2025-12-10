<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\School;

/**
 * Authentication Controller
 * Handles registration, login, and logout
 */
class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin(): void
    {
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/login', [
            'csrf_token' => $this->generateCsrfToken(),
        ], 'public');
    }

    /**
     * Process login
     */
    public function login(): void
    {
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/login');
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($this->auth->attempt($email, $password)) {
            $this->setFlash('success', 'تم تسجيل الدخول بنجاح');
            $this->redirect('/dashboard');
        } else {
            $this->setFlash('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
            $this->redirect('/login');
        }
    }

    /**
     * Show student registration form
     */
    public function showRegisterStudent(): void
    {
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        $schoolModel = new School($this->config);
        $schools = $schoolModel->findAll(['status' => 'active']);
        
        $this->render('auth/register_student', [
            'csrf_token' => $this->generateCsrfToken(),
            'schools' => $schools,
        ], 'public');
    }

    /**
     * Process student registration
     */
    public function registerStudent(): void
    {
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/register/student');
        }
        
        $validator = new Validator($_POST);
        $validator
            ->required('name', 'الاسم مطلوب')
            ->required('email', 'البريد الإلكتروني مطلوب')
            ->email('email')
            ->required('password', 'كلمة المرور مطلوبة')
            ->min('password', 8, 'كلمة المرور يجب أن تكون 8 أحرف على الأقل')
            ->matches('password_confirmation', 'password', 'كلمة المرور غير متطابقة')
            ->required('phone', 'رقم الهاتف مطلوب')
            ->phone('phone')
            ->required('gender', 'الجنس مطلوب')
            ->in('gender', ['male', 'female'])
            ->required('date_of_birth', 'تاريخ الميلاد مطلوب')
            ->date('date_of_birth')
            ->required('grade', 'الصف الدراسي مطلوب')
            ->required('school_id', 'المدرسة مطلوبة');
        
        // If "other" school is selected, validate the school name
        if ($_POST['school_id'] === 'other') {
            $validator->required('other_school_name', 'اسم المدرسة مطلوب');
        }
        
        $userModel = new User($this->config);
        
        // Get database connection for validation
        require_once $this->config['paths']['root'] . '/config/database.php';
        $db = getDatabase($this->config);
        
        $validator->unique('email', $db, 'users', 'email', null, 'البريد الإلكتروني مستخدم بالفعل');
        
        if ($validator->fails()) {
            $this->setFlash('error', 'يرجى تصحيح الأخطاء في النموذج');
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/register/student');
        }
        
        try {
            // Handle "other" school option
            $schoolId = $_POST['school_id'];
            if ($schoolId === 'other' && !empty($_POST['other_school_name'])) {
                // Create new school with pending status
                $schoolModel = new School($this->config);
                $schoolId = $schoolModel->create([
                    'name' => $_POST['other_school_name'],
                    'type' => 'government', // Default type
                    'governorate' => 'غير محدد', // Will be updated by admin
                    'city' => '',
                    'status' => 'pending',
                ]);
            }
            
            // Create user
            $userId = $userModel->createUser([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'type' => 'student',
                'status' => 'active',
            ]);
            
            // Create student profile
            $profileModel = new StudentProfile($this->config);
            $profileModel->create([
                'user_id' => $userId,
                'gender' => $_POST['gender'],
                'date_of_birth' => $_POST['date_of_birth'],
                'grade' => $_POST['grade'],
                'school_id' => $schoolId,
                'guardian_name' => $_POST['guardian_name'] ?? null,
                'guardian_phone' => $_POST['guardian_phone'] ?? null,
            ]);
            
            // Auto-login
            $this->auth->attempt($_POST['email'], $_POST['password']);
            
            $this->setFlash('success', 'تم التسجيل بنجاح');
            $this->redirect('/dashboard');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التسجيل');
            $this->redirect('/register/student');
        }
    }

    /**
     * Show school coordinator registration form
     */
    public function showRegisterSchool(): void
    {
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/register_school', [
            'csrf_token' => $this->generateCsrfToken(),
        ], 'public');
    }

    /**
     * Process school coordinator registration
     */
    public function registerSchool(): void
    {
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/register/school');
        }
        
        $validator = new Validator($_POST);
        $validator
            ->required('name', 'الاسم مطلوب')
            ->required('email', 'البريد الإلكتروني مطلوب')
            ->email('email')
            ->required('password', 'كلمة المرور مطلوبة')
            ->min('password', 8)
            ->matches('password_confirmation', 'password')
            ->required('phone')
            ->phone('phone')
            ->required('school_name', 'اسم المدرسة مطلوب')
            ->required('school_governorate', 'المحافظة مطلوبة')
            ->required('school_type', 'نوع المدرسة مطلوب')
            ->in('school_type', ['government', 'private', 'unrwa']);
        
        if ($validator->fails()) {
            $this->setFlash('error', 'يرجى تصحيح الأخطاء في النموذج');
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/register/school');
        }
        
        try {
            // Create school
            $schoolModel = new School($this->config);
            $schoolId = $schoolModel->create([
                'name' => $_POST['school_name'],
                'type' => $_POST['school_type'],
                'governorate' => $_POST['school_governorate'],
                'city' => $_POST['school_city'] ?? null,
                'address' => $_POST['school_address'] ?? null,
                'contact_email' => $_POST['email'],
                'contact_phone' => $_POST['phone'],
                'status' => 'pending', // Needs admin approval
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            // Create coordinator user
            $userModel = new User($this->config);
            $userId = $userModel->createUser([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'type' => 'school_coordinator',
                'status' => 'pending', // Needs admin approval
            ]);
            
            // Link coordinator to school
            $schoolModel->addCoordinator($schoolId, $userId);
            
            $this->setFlash('success', 'تم إرسال طلب التسجيل. سيتم مراجعته من قبل الإدارة');
            $this->redirect('/login');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التسجيل');
            $this->redirect('/register/school');
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        $this->auth->logout();
        $this->setFlash('success', 'تم تسجيل الخروج بنجاح');
        $this->redirect('/');
    }
}
