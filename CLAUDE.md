# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based tip calculator web application called "Tip Rounder" that calculates tips for services and provides rounding options. The application allows users to input a bill amount and tip percentage, then displays the exact tip amount along with rounded up and down alternatives. The project uses Laravel 12 with Vite for asset building, TailwindCSS for styling, and HTMX for dynamic interactions.

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
- **Interactive**: HTMX for dynamic form submissions
- **Assets**: Located in `resources/css/` and `resources/js/`
- **Views**: Blade templates in `resources/views/`

### Key Files Structure
- `routes/web.php` - Web routes with home page and tip calculation endpoint
- `resources/views/welcome.blade.php` - Main tip calculator form page
- `resources/views/tips/index.blade.php` - Tip calculation results page
- `app/Http/Controllers/CalculateTipController.php` - Controller for tip calculations
- `app/Actions/CalculateTipAction.php` - Action class for tip calculation logic
- `app/Http/Requests/CalculateTipRequest.php` - Form request validation
- `app/Dtos/TipRequestItem.php` - Data transfer object for tip requests
- `app/Dtos/TipResultsItem.php` - Data transfer object for tip results
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

### Application Features
- **Tip Calculator**: Calculate tips based on bill amount and tip percentage
- **Rounding Options**: Shows exact tip amount, rounded up, and rounded down
- **Dynamic UI**: HTMX-powered form submissions without page refreshes
- **Rate Limiting**: 30 requests per 2 minutes to prevent abuse
- **Responsive Design**: Mobile-friendly interface with TailwindCSS

### Code Standards
- **PHP**: Strict types enabled, final classes where applicable
- **Return Types**: All methods have explicit return types
- **Architecture**: Action-based pattern with DTOs for data transfer
- **Validation**: Form request validation for user inputs

### Database
- Uses SQLite for development
- Migrations are in `database/migrations/`
- Seeders are in `database/seeders/`
- User factory available in `database/factories/`