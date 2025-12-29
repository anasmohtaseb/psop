<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Competition;
use App\Models\CompetitionEdition;
use App\Models\User;
use App\Models\Registration;

/**
 * @OA\Info(
 *     title="Palestine Science Olympiad Portal API",
 *     version="1.0.0",
 *     description="RESTful API for managing science olympiad competitions, registrations, and users",
 *     @OA\Contact(
 *         email="info@psop.ps",
 *         name="PSOP Support"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:82/psop/api/v1",
 *     description="Local Development Server"
 * )
 * 
 * @OA\Server(
 *     url="https://psop.ps/api/v1",
 *     description="Production Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ApiController extends Controller
{
    /**
     * Enable CORS for API requests
     */
    protected function enableCors(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Return JSON response
     */
    protected function jsonResponse(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Return error response
     */
    protected function errorResponse(string $message, int $status = 400, array $errors = []): void
    {
        $this->jsonResponse([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Return success response
     */
    protected function successResponse($data, string $message = 'Success', int $status = 200): void
    {
        $this->jsonResponse([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Verify API token (simple implementation)
     */
    protected function verifyToken(): ?array
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        
        if (!preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return null;
        }
        
        $token = $matches[1];
        
        // Simple token verification (in production, use JWT)
        if (empty($token)) {
            return null;
        }
        
        // For now, return mock user data
        // In production, decode JWT and get user from database
        return [
            'id' => 1,
            'name' => 'API User',
            'type' => 'admin'
        ];
    }

    /**
     * Require authentication
     */
    protected function requireApiAuth(): array
    {
        $user = $this->verifyToken();
        
        if (!$user) {
            $this->errorResponse('Unauthorized', 401);
        }
        
        return $user;
    }
}
