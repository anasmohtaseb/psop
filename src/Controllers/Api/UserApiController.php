<?php

namespace App\Controllers\Api;

use App\Models\User;
use App\Models\StudentProfile;

class UserApiController extends ApiController
{
    private User $userModel;
    private StudentProfile $studentProfileModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->enableCors();
        $this->userModel = new User($this->config);
        $this->studentProfileModel = new StudentProfile($this->config);
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Get all users",
     *     description="Returns list of users (Admin only)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Filter by user type",
     *         required=false,
     *         @OA\Schema(type="string", enum={"student", "admin", "school_coordinator", "trainer"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"active", "inactive", "pending"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(): void
    {
        $user = $this->requireApiAuth();
        
        if ($user['type'] !== 'admin') {
            $this->errorResponse('Forbidden', 403);
        }
        
        $filters = [];
        
        if (isset($_GET['type'])) {
            $filters['type'] = $_GET['type'];
        }
        
        if (isset($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        
        $users = $this->userModel->findAll($filters, 100);
        
        // Remove sensitive data
        $users = array_map(function($u) {
            unset($u['password_hash']);
            return $u;
        }, $users);
        
        $this->successResponse($users, 'Users retrieved successfully');
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Get user by ID",
     *     description="Returns a single user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show($id): void
    {
        $currentUser = $this->requireApiAuth();
        
        $userId = (int)$id;
        $user = $this->userModel->findById($userId);
        
        if (!$user) {
            $this->errorResponse('User not found', 404);
        }
        
        // Only admin or the user themselves can view
        if ($currentUser['type'] !== 'admin' && $currentUser['id'] !== $userId) {
            $this->errorResponse('Forbidden', 403);
        }
        
        unset($user['password_hash']);
        
        // Get student profile if user is a student
        if ($user['type'] === 'student') {
            $profile = $this->studentProfileModel->findByUserId($userId);
            $user['profile'] = $profile;
        }
        
        $this->successResponse($user, 'User retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Authentication"},
     *     summary="Register new user",
     *     description="Register a new student user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "phone"},
     *             @OA\Property(property="name", type="string", example="أحمد محمد"),
     *             @OA\Property(property="email", type="string", example="ahmad@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="phone", type="string", example="0599123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validation
        $required = ['name', 'email', 'password', 'phone'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "The {$field} field is required";
            }
        }
        
        // Check if email exists
        if (!empty($data['email'])) {
            $existing = $this->userModel->findByEmail($data['email']);
            if ($existing) {
                $errors['email'] = 'Email already exists';
            }
        }
        
        if (!empty($errors)) {
            $this->errorResponse('Validation failed', 400, $errors);
        }
        
        // Create user
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'phone' => $data['phone'],
            'type' => 'student',
            'status' => 'active'
        ];
        
        $userId = $this->userModel->create($userData);
        
        if ($userId) {
            logCreate('user', $userId, 'تسجيل مستخدم جديد عبر API: ' . $data['name']);
            
            $this->successResponse([
                'id' => $userId,
                'message' => 'Registration successful'
            ], 'User registered successfully', 201);
        } else {
            $this->errorResponse('Failed to register user', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     description="Authenticate user and return token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['email']) || empty($data['password'])) {
            $this->errorResponse('Email and password are required', 400);
        }
        
        $user = $this->userModel->findByEmail($data['email']);
        
        if (!$user || !password_verify($data['password'], $user['password_hash'])) {
            $this->errorResponse('Invalid credentials', 401);
        }
        
        // Generate token (simplified - use JWT in production)
        $token = base64_encode($user['id'] . ':' . time());
        
        unset($user['password_hash']);
        
        logLogin($user['id'], $user['name']);
        
        $this->successResponse([
            'token' => $token,
            'user' => $user
        ], 'Login successful');
    }
}
