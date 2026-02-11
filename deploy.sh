#!/bin/bash
# Deployment script for production server
# Upload this file to your server and run: bash deploy.sh

echo "🚀 Starting deployment..."

# Navigate to project directory
cd /home/u186996263/domains/psop.ps/public_html

# Pull latest changes from Git
echo "📥 Pulling latest changes from GitHub..."
git pull origin main

# Set correct permissions
echo "🔒 Setting permissions..."
chmod -R 755 .
chmod -R 644 views/
chmod -R 644 src/
chmod -R 775 public/uploads/

# Clear any PHP cache if needed
echo "🧹 Clearing cache..."
find . -name "*.php" -type f -exec touch {} \;

echo "✅ Deployment completed successfully!"
echo "📋 Now visit: https://psop.ps/check_views.php to verify files"
