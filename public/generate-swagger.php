<?php
/**
 * Generate Swagger/OpenAPI JSON documentation
 * Run: php generate-swagger.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/../src/Controllers/Api'
]);

// Save to public directory
file_put_contents(
    __DIR__ . '/../public/swagger.json',
    $openapi->toJson()
);

echo "Swagger documentation generated successfully!\n";
echo "Access at: http://localhost:82/psop/api/docs\n";
