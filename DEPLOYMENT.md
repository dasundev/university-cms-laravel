## Laravel Deployment Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/dasundev/university-cms-laravel.git
   cd university-cms-laravel
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Set up environment variables**
    - Copy `.env.example` to `.env` and update values as needed.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations and seeders**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Optimize configuration and cache**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

6. **Link storage**
   ```bash
   php artisan storage:link
   ```

7. **Set correct permissions**
    - Ensure `storage` and `bootstrap/cache` are writable by the web server.

8. **Serve the application**
    - Use a web server (Nginx/Apache) pointing to `public/index.php`.
