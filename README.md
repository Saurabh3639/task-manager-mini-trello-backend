# Task Manager API (Mini Trello Backend)

A production-style REST API for a Kanban based Task Management system inspired by Trello.
The API allows users to manage boards, columns, and tasks with drag-and-drop style updates natively syncing to the frontend database.

Built with **Laravel**, **JWT Authentication**, and **MySQL**.

---

# Tech Stack

* **Framework:** Laravel 9 (PHP ^8.0.2)
* **Authentication:** JWT (`tymon/jwt-auth`)
* **Database:** MySQL
* **API Style:** RESTful JSON
* **Architecture:** MVC with clean layer isolation (Controllers, Requests, Services, Resources)

---

# Features

### Authentication
* User Registration
* User Login
* Get Current User
* Logout
* Refresh Token

### Boards
* Create Board
* Get All Boards for User
* **Smart Aggregations:** Native `tasks_count` computed via Laravel Relational Aggregation mapping (`withCount`)
* Update Board
* Delete Board

### Columns
* Create Column inside Board
* Get Columns by Board
* Update Column
* Delete Column

### Tasks
* Create Task
* Get Tasks by Column
* Update Task
* Delete Task
* Move Task natively

### Drag & Drop Support
Tasks can be moved between columns by patching the entity logic:
* `column_id`
* `position`

Example: `Todo → In Progress` maps the underlying foreign keys instantly.

---

# Database Structure

## Users
```
id | name | email | password | created_at | updated_at
```

## Boards
```
id | user_id | title | created_at | updated_at
```

## Columns
```
id | board_id | title | position | created_at | updated_at
```

## Tasks
```
id | board_id | column_id | title | description | priority | due_date | position | created_at | updated_at
```

*(Note: Data schemas follow Laravel's Eloquent naming conventions for simple scaling.)*

---

# API Endpoints (v1)

### Authentication
* `POST` `/api/v1/register`
* `POST` `/api/v1/login`
* `GET` `/api/v1/me`
* `POST` `/api/v1/logout`

### Boards
* `POST` `/api/v1/boards`
* `GET` `/api/v1/boards` (Returns Board properties integrated with `tasks_count`)
* `PATCH` `/api/v1/boards/{id}`
* `DELETE` `/api/v1/boards/{id}`

### Columns
* `POST` `/api/v1/columns`
* `GET` `/api/v1/columns?board_id={id}`
* `PATCH` `/api/v1/columns/{id}`
* `DELETE` `/api/v1/columns/{id}`

### Tasks
* `POST` `/api/v1/tasks`
* `GET` `/api/v1/tasks?column_id={id}`
* `PATCH` `/api/v1/tasks/{id}` (Used for standard edits and drag-and-drop positional updates)
* `DELETE` `/api/v1/tasks/{id}`

*(All Protected routes require the `Authorization: Bearer {JWT_TOKEN}` header component)*

---

# Installation & Server Booting

Clone repository
```bash
git clone <repository-url>
```

Install dependencies
```bash
composer install
```

Copy environment file
```bash
cp .env.example .env
```

Generate application key
```bash
php artisan key:generate
```

Generate JWT secret
```bash
php artisan jwt:secret
```

Configure local database properties in `.env`:
```
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations (Build schemas)
```bash
php artisan migrate
```

Start testing server
```bash
php artisan serve
```

---

# Architecture (Production-Level Structure)

This project avoids "Fat Controllers" by heavily following **Clean API Architecture**.

```
app
├ Http
│ ├ Controllers        # Entrypoints routing the HTTP requests
│ ├ Requests           # Custom Form Requests handling explicit payload validation
│ ├ Middleware
│
├ Models               # Base Database eloquent mapping models
│
├ Services             # Complex business/database mutator layer
│
├ Policies             # Authorization rules
│
├ Resources            # API Json Response formatters standardizing returned properties
│
├ Helpers              # Clean utility integrations
```

## Key Layers Highlighted
* **Controller Layer**: Extremely thin mapping connecting HTTP endpoints to Services.
* **Form Request Validation**: Handled out-of-controller via Laravel FormRequests ensuring payload safety and reducing duplicate logic. 
* **Service Layer**: Houses the isolated business logic rendering testing/mutations drastically safer than typical CRUD apps.
* **API Resources**: Sanitizes responses. Maps timestamps clearly, removes underlying foreign keys if irrelevant, exposes relationship counts like `tasks_count` dynamically.
* **Authorization Policies**: Protects endpoints at the model-level ensuring a user cannot mutate, patch, or drop a board/task they do not own.

---

# Author
**Saurabh Phawade**
(Full Stack Developer)
