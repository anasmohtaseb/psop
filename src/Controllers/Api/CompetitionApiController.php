<?php

namespace App\Controllers\Api;

use App\Models\Competition;
use App\Models\CompetitionEdition;

class CompetitionApiController extends ApiController
{
    private Competition $competitionModel;
    private CompetitionEdition $editionModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->enableCors();
        $this->competitionModel = new Competition($this->config);
        $this->editionModel = new CompetitionEdition($this->config);
    }

    /**
     * @OA\Get(
     *     path="/competitions",
     *     tags={"Competitions"},
     *     summary="Get all competitions",
     *     description="Returns list of all active competitions",
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by category",
     *         required=false,
     *         @OA\Schema(type="string", enum={"mathematics", "informatics", "physics", "chemistry", "biology", "ai", "cybersecurity"})
     *     ),
     *     @OA\Parameter(
     *         name="is_active",
     *         in="query",
     *         description="Filter by active status",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name_ar", type="string"),
     *                     @OA\Property(property="name_en", type="string"),
     *                     @OA\Property(property="code", type="string"),
     *                     @OA\Property(property="category", type="string"),
     *                     @OA\Property(property="is_active", type="boolean")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): void
    {
        $filters = [];
        
        if (isset($_GET['category'])) {
            $filters['category'] = $_GET['category'];
        }
        
        if (isset($_GET['is_active'])) {
            $filters['is_active'] = $_GET['is_active'] === 'true' ? 1 : 0;
        }
        
        $competitions = $this->competitionModel->findAll($filters);
        
        $this->successResponse($competitions, 'Competitions retrieved successfully');
    }

    /**
     * @OA\Get(
     *     path="/competitions/{id}",
     *     tags={"Competitions"},
     *     summary="Get competition by ID",
     *     description="Returns a single competition",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Competition ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Competition not found"
     *     )
     * )
     */
    public function show($id): void
    {
        $competition = $this->competitionModel->findById((int)$id);
        
        if (!$competition) {
            $this->errorResponse('Competition not found', 404);
        }
        
        // Get editions for this competition
        $editions = $this->editionModel->findAll(['competition_id' => $id]);
        $competition['editions'] = $editions;
        
        $this->successResponse($competition, 'Competition retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/competitions",
     *     tags={"Competitions"},
     *     summary="Create new competition",
     *     description="Create a new competition (Admin only)",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name_ar", "name_en", "code", "category"},
     *             @OA\Property(property="name_ar", type="string", example="الأولمبياد الدولي للرياضيات"),
     *             @OA\Property(property="name_en", type="string", example="International Mathematical Olympiad"),
     *             @OA\Property(property="code", type="string", example="IMO"),
     *             @OA\Property(property="category", type="string", example="mathematics"),
     *             @OA\Property(property="description_ar", type="string"),
     *             @OA\Property(property="description_en", type="string"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Competition created successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function create(): void
    {
        $user = $this->requireApiAuth();
        
        if ($user['type'] !== 'admin') {
            $this->errorResponse('Forbidden', 403);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validation
        $required = ['name_ar', 'name_en', 'code', 'category'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "The {$field} field is required";
            }
        }
        
        if (!empty($errors)) {
            $this->errorResponse('Validation failed', 400, $errors);
        }
        
        $id = $this->competitionModel->create($data);
        
        if ($id) {
            logCreate('competition', $id, 'إنشاء مسابقة عبر API: ' . $data['name_ar']);
            $this->successResponse(['id' => $id], 'Competition created successfully', 201);
        } else {
            $this->errorResponse('Failed to create competition', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/competitions/{id}",
     *     tags={"Competitions"},
     *     summary="Update competition",
     *     description="Update an existing competition (Admin only)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Competition ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name_ar", type="string"),
     *             @OA\Property(property="name_en", type="string"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Competition updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Competition not found"
     *     )
     * )
     */
    public function update($id): void
    {
        $user = $this->requireApiAuth();
        
        if ($user['type'] !== 'admin') {
            $this->errorResponse('Forbidden', 403);
        }
        
        $competition = $this->competitionModel->findById((int)$id);
        
        if (!$competition) {
            $this->errorResponse('Competition not found', 404);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        $success = $this->competitionModel->update((int)$id, $data);
        
        if ($success) {
            logUpdate('competition', (int)$id, 'تحديث مسابقة عبر API: ' . $competition['name_ar']);
            $this->successResponse(null, 'Competition updated successfully');
        } else {
            $this->errorResponse('Failed to update competition', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/competitions/{id}",
     *     tags={"Competitions"},
     *     summary="Delete competition",
     *     description="Delete a competition (Admin only)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Competition ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Competition deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Competition not found"
     *     )
     * )
     */
    public function delete($id): void
    {
        $user = $this->requireApiAuth();
        
        if ($user['type'] !== 'admin') {
            $this->errorResponse('Forbidden', 403);
        }
        
        $competition = $this->competitionModel->findById((int)$id);
        
        if (!$competition) {
            $this->errorResponse('Competition not found', 404);
        }
        
        $success = $this->competitionModel->delete((int)$id);
        
        if ($success) {
            logDelete('competition', (int)$id, 'حذف مسابقة عبر API: ' . $competition['name_ar']);
            $this->successResponse(null, 'Competition deleted successfully');
        } else {
            $this->errorResponse('Failed to delete competition', 500);
        }
    }
}
