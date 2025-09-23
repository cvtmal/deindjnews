# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Starting the development environment
```bash
# Full development stack with hot-reload (includes server, queue, logs, and vite)
composer dev

# Or run individual services:
php artisan serve              # Start development server
php artisan queue:listen       # Start queue worker
php artisan pail               # Watch Laravel logs in real-time
npm run dev                    # Start Vite dev server
```

### Testing
```bash
# Run all tests with Pest
composer test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific file or directory
./vendor/bin/pint app/Http/Controllers
```

### Build Commands
```bash
# Build frontend assets
npm run build

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh database with seeders
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_example_table
```

## Architecture Overview

### Laravel 12 Structure
This is a fresh Laravel 12 application using:
- **Pest** for testing (configured in `tests/Pest.php`)
- **Vite** for asset bundling with Tailwind CSS v4
- **Laravel Pint** for code formatting
- **SQLite** as default database (in-memory for tests)

### Key Directories
- `app/Http/Controllers/` - HTTP controllers
- `app/Models/` - Eloquent models
- `app/Providers/` - Service providers
- `routes/web.php` - Web routes
- `routes/console.php` - Artisan commands
- `database/migrations/` - Database migrations
- `database/factories/` - Model factories
- `database/seeders/` - Database seeders
- `tests/Feature/` - Feature tests (using Pest)
- `tests/Unit/` - Unit tests (using Pest)
- `resources/views/` - Blade templates
- `resources/js/` - JavaScript assets
- `resources/css/` - CSS assets

### Testing Strategy
Tests are written using Pest PHP. Feature tests extend the base TestCase and can use Laravel's testing helpers like `RefreshDatabase` trait. The Pest configuration in `tests/Pest.php` sets up custom expectations and helper functions.

### Configuration
- Environment variables are managed through `.env` file
- Database uses SQLite by default (`database/database.sqlite`)
- Testing uses in-memory SQLite database
- Queue connection is set to `sync` for development