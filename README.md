# Task Manager API (Mini Trello Backend)

A production-style REST API for a Kanban based Task Management system inspired by Trello.
The API allows users to manage boards, columns, and tasks with drag-and-drop style updates.

Built with **Laravel**, **JWT Authentication**, and **MySQL**.

---

# Tech Stack

* **Framework:** Laravel
* **Authentication:** JWT (`tymon/jwt-auth`)
* **Database:** MySQL
* **API Style:** RESTful
* **Architecture:** MVC with clean API structure

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

### Drag & Drop Support

Tasks can be moved between columns by updating:

* `column_id`
* `position`

Example:

Todo → In Progress

---

# Database Structure

## Users

```
id
name
email
password
created_at
updated_at
```

## Boards

```
id
user_id
title
created_at
updated_at
```

## Columns

```
id
board_id
title
position
created_at
updated_at
```

## Tasks

```
id
board_id
column_id
title
description
priority
due_date
position
created_at
updated_at
```

---

# API Endpoints

## Authentication

### Register

POST `/api/register`

```
{
"name": "Saurabh",
"email": "user@test.com",
"password": "password"
}
```

### Login

POST `/api/login`

Returns JWT token.

### Current User

GET `/api/me`

### Logout

POST `/api/logout`

### Refresh Token

POST `/api/refresh`

---

## Boards

### Create Board

POST `/api/boards`

```
{
"title": "Project Board"
}
```

### Get Boards

GET `/api/boards`

### Update Board

PATCH `/api/boards/{id}`

### Delete Board

DELETE `/api/boards/{id}`

---

## Columns

### Create Column

POST `/api/columns`

```
{
"board_id": 1,
"title": "Todo",
"position": 1
}
```

### Get Columns by Board

GET `/api/columns?board_id=1`

### Update Column

PATCH `/api/columns/{id}`

### Delete Column

DELETE `/api/columns/{id}`

---

## Tasks

### Create Task

POST `/api/tasks`

```
{
"board_id": 1,
"column_id": 1,
"title": "Build Login API",
"description": "Implement JWT authentication",
"priority": "high",
"position": 1
}
```

### Get Tasks

GET `/api/tasks?column_id=1`

### Update Task

PATCH `/api/tasks/{id}`

Example for drag-drop move:

```
{
"column_id": 2,
"position": 1
}
```

### Delete Task

DELETE `/api/tasks/{id}`

---

# Authentication

All protected routes require:

```
Authorization: Bearer {JWT_TOKEN}
```

Example:

```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJh...
```

---

# Installation

Clone repository

```
git clone https://github.com/your-username/task-manager-api.git
```

Install dependencies

```
composer install
```

Copy environment file

```
cp .env.example .env
```

Generate application key

```
php artisan key:generate
```

Generate JWT secret

```
php artisan jwt:secret
```

Configure database in `.env`

```
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations

```
php artisan migrate
```

Start server

```
php artisan serve
```

API will run at:

```
http://localhost:8000/api
```

---

# Example Project Structure

```
app
 ├ Http
 │   ├ Controllers
 │   ├ Middleware
 │
 ├ Models
 ├ Policies
 ├ Requests
 ├ Resources
 │
database
 ├ migrations

routes
 ├ api.php
```

---

# Recently Implemented Improvements (Production Grade Architecture)

The following improvements have been completely integrated:

* **API Resources** mapping domain models to concise, consistent JSON payloads structure.
* **Form Request classes** extracted from Controllers to strictly handle Request Validation.
* **Service classes** created specifically for complex database and business logic.
* **Authorization Policies** implemented preventing users from mutating assets they do not own.

---

# Architecture (Production-Level Structure)

This project follows a **clean API architecture commonly used in production Laravel applications**.

Instead of placing all logic inside controllers, responsibilities are separated into different layers.

```
app
├ Http
│ ├ Controllers        # Handle HTTP requests
│ ├ Requests           # Validation classes
│ ├ Middleware
│
├ Models               # Database models
│
├ Services             # Business logic layer
│
├ Policies             # Authorization rules
│
├ Resources            # API response formatting
│
├ Helpers              # Shared helper utilities
```

---

# Controller Layer

Controllers remain **thin** and only handle:

* Request handling
* Calling services
* Returning responses

Example responsibilities:

```
BoardController
ColumnController
TaskController
AuthController
```

---

# Request Validation Layer

All validation logic is moved into **Form Request classes** instead of controllers.

Example:

```
StoreBoardRequest
UpdateBoardRequest
StoreTaskRequest
UpdateTaskRequest
```

Benefits:

* Cleaner controllers
* Reusable validation
* Better maintainability

---

# Service Layer

Business logic is handled inside **Service classes**.

Example:

```
BoardService
TaskService
ColumnService
```

Services manage:

* Database operations
* Business rules
* Complex logic

Controllers simply call services.

Example:

```
Controller → Service → Model
```

---

# API Resources

API responses are formatted using **Laravel API Resource classes**.

Example:

```
BoardResource
ColumnResource
TaskResource
```

Benefits:

* Consistent API responses
* Hide unnecessary fields
* Easier API versioning

Example response:

```
{
  "id": 1,
  "title": "Project Board",
  "created_at": "2026-03-16"
}
```

---

# Authorization Policies

Authorization rules are defined using **Laravel Policies**.

Example:

```
BoardPolicy
TaskPolicy
```

This ensures:

* Users can only modify their own boards
* Unauthorized access is prevented

Example rule:

```
User can update board only if board.user_id == user.id
```

---

# API Response Format

All responses follow a **consistent JSON structure**.

Example success response:

```
{
  "success": true,
  "message": "Task updated successfully",
  "data": {}
}
```

Example error response:

```
{
  "success": false,
  "message": "Unauthorized"
}
```

---

# Performance Improvements

The API includes several performance practices:

* **Pagination** for large datasets
* **Eager Loading** to prevent N+1 queries
* Proper **database indexing through migrations**

Example:

```
Board::with('columns.tasks')->get();
```

---

# API Versioning

Routes are structured to allow versioning.

Example:

```
/api/v1/boards
/api/v1/tasks
```

This allows future API upgrades without breaking existing clients.

---

# Author

Saurabh Phawade
Full Stack Developer

Tech Stack:
React • Next.js • Laravel • Node.js • MySQL • MongoDB
