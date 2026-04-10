#!/bin/bash

# Solidnew Production Deployment Script
# Usage: bash deploy.sh <server_ip>

set -e

SERVER_IP=${1:-161.97.120.209}
REMOTE_PATH="/opt/solidnew"
LOCAL_PATH="."

echo "🚀 Starting deployment to $SERVER_IP..."

# Step 1: Create deployment package
echo "📦 Creating deployment package..."
mkdir -p deployment
cp -r $LOCAL_PATH/* deployment/
cd deployment

# Step 2: Transfer to server
echo "📤 Transferring files to server..."
scp -r . root@$SERVER_IP:$REMOTE_PATH/

# Step 3: Execute setup on server
echo "⚙️  Configuring server..."
ssh root@$SERVER_IP << 'EOF'
  set -e
  cd /opt/solidnew
  
  echo "📁 Creating directories..."
  mkdir -p storage/logs bootstrap/cache docker/logs
  
  echo "🔐 Setting permissions..."
  chmod -R 775 storage bootstrap/cache
  chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
  
  echo "🐳 Building Docker image..."
  docker build -t solidnew-app:latest -f Dockerfile.prod .
  
  echo "🚀 Starting services..."
  docker compose -f docker-compose.prod.yml up -d
  
  echo "⏳ Waiting for services to be ready..."
  sleep 10
  
  echo "✅ Deployment complete!"
  docker compose -f docker-compose.prod.yml ps
EOF

echo "✨ Deployment successful!"
echo "🌐 Access your application at: http://$SERVER_IP:8085"

# Cleanup
cd ..
rm -rf deployment

