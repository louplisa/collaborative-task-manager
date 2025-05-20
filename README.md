# 📋 Collaborative Task Manager

A Laravel 12 web application for collaborative project and task management with user roles, permissions, and access control policies.

---

## 🚀 Features

- User authentication using Laravel Breeze
- Role-based access control: admin, manager, user
- Full CRUD for Projects
- Task creation and assignment to users within a project
- Native Laravel PHP Enum for task statuses: `to do`, `in progress`, `done`
- Authorization using Laravel Policies
- Responsive UI with Bootstrap or Tailwind CSS
- Dockerized development with Laravel Sail

---

## 📦 Tech Stack

- Laravel 12
- PHP 8.2+
- Laravel Breeze (auth scaffolding)
- Laravel Sail (Docker environment)
- MySQL or PostgreSQL
- Bootstrap or Tailwind CSS
- Native PHP Enums for statuses
- Livewire V3

---

## 🛠️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/louplisa/collaborative-task-manager.git
cd collaborative-task-manager
```

### 2. Install dependencies
```bash
composer install
npm install && npm run dev
```

### 3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Start the Docker environment
```bash
./vendor/bin/sail up -d
```

### 5. Run migrations and seeders
```bash
./vendor/bin/sail artisan migrate --seed
```
