# Laravel + Vue Product Management System



## Prerequisites

Before you begin, ensure you have the following installed:
- PHP >= 8.1
- Composer
- Node.js & NPM 
- MySQL
- Git

## Installation Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/ahmadullahchowdhury/laravel-vue.git
   cd <project-directory>
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Then edit .env file with your database credentials

4. Run migrations:
   ```bash
   php artisan migrate:refresh --seed
   ```

5. Start the development server:
   ```bash
   php artisan serve
   npm run dev
   ```

6. Access the application in your browser at `http://localhost:8000 or http://127.0.0.1:8000`   