#!/bin/bash

# Create necessary directories
echo "Creating required directories..."
mkdir -p web/storage/app/public
mkdir -p web/storage/framework/{sessions,views,cache}
mkdir -p web/bootstrap/cache
mkdir -p nginx/conf.d
mkdir -p minio/data

# Set permissions
echo "Setting permissions..."
chmod -R 775 web/storage
chmod -R 775 web/bootstrap/cache

# Create environment files
echo "Creating environment files..."
cat > .env << EOL
DB_DATABASE=ojibwe_tales
DB_USERNAME=postgres
DB_PASSWORD=postgres
AWS_ACCESS_KEY_ID=minioadmin
AWS_SECRET_ACCESS_KEY=minioadmin
EOL

# Build and start containers
echo "Building and starting containers..."
docker-compose up -d --build

# Wait for services to be ready
echo "Waiting for services to be ready..."
sleep 10

# Run Laravel migrations
echo "Running Laravel migrations..."
docker-compose exec app php artisan migrate

# Create MinIO bucket
echo "Creating MinIO bucket..."
docker-compose exec minio mc mb minio/ojibwe-tales-videos --ignore-existing

echo "Setup complete! The application should be available at http://localhost:8000" 