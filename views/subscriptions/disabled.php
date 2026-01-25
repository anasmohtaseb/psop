<?php
/**
 * Subscriptions Disabled Page
 */

// Prevent caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscriptions Unavailable - Palestine Science Olympiad Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Almarai', sans-serif;
        }

        .error-container {
            background: white;
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }

        .error-icon {
            font-size: 80px;
            color: #f59e0b;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(0.95);
            }
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            border: none;
            color: #374151;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s, background 0.2s;
        }

        .btn-secondary:hover {
            background: #d1d5db;
            transform: translateY(-2px);
            color: #374151;
        }

        .info-box {
            background: #eff6ff;
            border-right: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: right;
        }

        .info-box-title {
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .info-box-text {
            color: #1e3a8a;
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="bi bi-exclamation-circle"></i>
        </div>

        <h1 class="error-title">Subscriptions Unavailable</h1>

        <p class="error-message">
            The subscriptions service is currently unavailable. 
            Please try again later or contact our support team for more information.
        </p>

        <div class="action-buttons">
            <a href="/" class="btn-primary">
                <i class="bi bi-house-fill"></i> Return Home
            </a>
            <a href="/psop/public/dashboard" class="btn-secondary">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>

        <div class="info-box">
            <div class="info-box-title">
                <i class="bi bi-info-circle"></i> نقل اللغة / Language
            </div>
            <p class="info-box-text">
                الخدمة غير متاحة حالياً. يرجى المحاولة لاحقاً أو التواصل مع فريق الدعم.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
