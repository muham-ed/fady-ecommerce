# Root README for Fady E-commerce

This repository contains the backend (Laravel) and frontend (Vue 3 + Vite) for the Fady E-commerce project.

Quick start with Docker (recommended):

1. Copy env files
   - cp fady-ecommerce-backend/.env.example fady-ecommerce-backend/.env
2. Build and run
   - docker-compose up --build -d
3. Run migrations and seeders
   - docker compose exec backend php artisan migrate --seed

Frontend will be served on port 5173 and backend on 8000 by default.

For more details see fady-ecommerce-backend/README.md
