# ZTAMS

ZTAMS © 2026 · Designed & Developed by Namra Saleem Ahmed

Laravel migration of the supplied Zindagi Trust Attendance Management System source project. The original React/Supabase source remains preserved in `../work/source-project/project` for UI and schema reference.

## Local setup (Windows)

1. Install PHP 8.2+, Composer, Node.js LTS and MySQL/MariaDB.
2. In this directory run `composer install`, `npm install`, `Copy-Item .env.example .env`, `php artisan key:generate`, `php artisan migrate --seed`, `npm run build`, then `php artisan serve`.
3. Browse to `http://127.0.0.1:8000`.

Demo-only accounts: `teacher@ztams.demo`, `admin@ztams.demo`, and `ceo@ztams.demo`; each uses password `demo1234`.

## Current implementation status

The migration, roles, base models, authentication controller, server-side class policy, attendance persistence, duplicate constraint, 09:00 Asia/Karachi lock predicate, audit helper, and SMS simulation abstraction have been created. The supplied machine does not contain PHP, Composer, Node, npm, or MySQL/MariaDB, so installation, database migration, application execution, UI completion, and automated-test verification remain blocked rather than being claimed as complete.
