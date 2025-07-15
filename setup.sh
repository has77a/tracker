#!/bin/bash

# Start Docker containers
echo "Starting Docker containers..."
docker compose up -d

# Run Composer install
echo "Running Composer..."
docker exec -it laravel_app composer install

# Run Laravel migrations
echo "Running Laravel migrations..."
docker exec -it laravel_app php artisan migrate

echo "✅ Setup complete."
