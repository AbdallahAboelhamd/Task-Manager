# 🚀 Enterprise Task Management API

A robust, secure, and scalable RESTful API built with **Laravel 11**. This project demonstrates advanced backend architecture, emphasizing strict security protocols, dynamic data filtering, and clean data presentation.

## 🛠️ Tech Stack & Tools
* **Framework:** Laravel 11 (PHP)
* **Authentication:** Laravel Sanctum (Bearer Token)
* **Authorization (RBAC):** Spatie Laravel-Permission
* **Database:** MySQL
* **API Testing:** Postman

## 🔥 Core Features
* **🔐 Secure Authentication:** Token-based login using Laravel Sanctum.
* **🛡️ Role-Based Access Control (RBAC):** Distinct roles (`Admin` vs `Employee`). Employees can only manage their own tasks, while Admins have global access.
* **👮 Strict Policies & Gates:** Business logic constraints ensuring users cannot delete or update tasks belonging to others.
* **🔍 Advanced Dynamic Filtering:** High-performance query building allowing dynamic searches by `status`, `priority`, and `keywords` directly via URL parameters.
* **📦 API Resources:** Clean, standardized, and professional JSON responses hiding sensitive database columns (like `created_at`).
* **⚡ Optimized Performance:** Implemented database pagination to handle large datasets efficiently.

## 📡 API Endpoints Overview

| Method | Endpoint | Access | Description |
|--------|----------|--------|-------------|
| POST | `/api/login` | Public | Authenticate user & issue Token |
| GET | `/api/projects` | Admin | List all projects |
| GET | `/api/tasks` | Auth | List tasks (Filtered by Role) |
| POST | `/api/tasks` | Auth | Create a new task |
| PUT | `/api/tasks/{id}` | Auth (Policy) | Update an existing task |
| DELETE | `/api/tasks/{id}` | Auth (Policy) | Delete a task |

## 💡 Dynamic Filtering Example
The API supports dynamic query parameters for frontend applications:
`GET /api/tasks?status=done&priority=high&search=backend`

---
*Built with passion and clean code principles.* ☕💻