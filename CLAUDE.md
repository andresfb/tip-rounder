# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based tip calculator web application called "Tip Rounder" that calculates tips for services and rounds them to the nearest whole number. The project uses Laravel 12 with Vite for asset building and TailwindCSS for styling.

## Development Commands

### Start Development Server
```bash
# Start all development services (server, queue, logs, vite)
composer dev
```

### Build Assets
```bash
# Build production assets
npm run build

# Start Vite development server
npm run dev
```

### Testing
```bash
# Run tests
composer test
```

### Laravel Commands
```bash
# Serve the application
php artisan serve

# Run migrations
php artisan migrate

# Clear application cache
php artisan config:clear

# Watch logs
php artisan pail --timeout=0

# Process queue jobs
php artisan queue:listen --tries=1
```

## Architecture

### Backend (Laravel)
- **Framework**: Laravel 12 with PHP 8.2+
- **Database**: SQLite (database/database.sqlite)
- **Testing**: Pest framework for testing
- **Queue**: Laravel queue system for background jobs
- **Logging**: Laravel Pail for log monitoring

### Frontend
- **CSS Framework**: TailwindCSS v4
- **Build Tool**: Vite with Laravel plugin
- **Assets**: Located in `resources/css/` and `resources/js/`
- **Views**: Blade templates in `resources/views/`

### Key Files Structure
- `routes/web.php` - Web routes, currently serves welcome page
- `resources/views/welcome.blade.php` - Main welcome page template
- `resources/js/app.js` - Main JavaScript entry point
- `resources/css/app.css` - Main CSS entry point with TailwindCSS imports
- `vite.config.js` - Vite configuration for asset building
- `composer.json` - PHP dependencies and scripts
- `package.json` - Node.js dependencies and scripts

### Development Workflow
The project uses a multi-service development setup via `composer dev` which concurrently runs:
- PHP artisan serve (web server)
- Queue listener for background jobs
- Pail for log monitoring
- Vite dev server for asset hot reloading

### Database
- Uses SQLite for development
- Migrations are in `database/migrations/`
- Seeders are in `database/seeders/`
- User factory available in `database/factories/`