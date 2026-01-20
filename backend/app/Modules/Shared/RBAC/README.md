# RBAC (Role-Based Access Control) Module

## Module Status
- **Stability:** Stable
- **Version:** v1.0
- **Introduced In:** Sprint 1
- **Backward Compatibility:** Guaranteed within major version

---

## Overview
The RBAC module provides a **centralized, permission-based authorization system** for the SmartLearn backend.

It enforces access control consistently across all modules while avoiding hardcoded role checks and controller-level authorization logic.  
The implementation is **Laravel 12 native**, scalable, and CI/CD safe.

---

## Design Principles
- Permission-driven authorization
- No role conditionals in controllers
- Centralized access control
- Laravel-native Gates & Middleware
- Cross-module reusability
- Enterprise-ready and auditable

---

## Module Structure
```text
modules/Shared/RBAC/
├── Models/
│   ├── Role.php
│   └── Permission.php
│
├── Middleware/
│   └── CheckPermission.php
│
├── Providers/
│   └── RBACServiceProvider.php
│
├── Database/
│   └── Migrations/
│
└── README.md
```

## Core Concepts

### Roles
Roles are permission containers, not logic holders.
Examples: Super Admin, Admin, Instructor, Student, Support
Stored in the roles table.

### Permissions
Permissions represent atomic system actions.

### Role → Permission Mapping

admin:
- user.view
- user.create
- user.update
- user.delete
- user.update.self

user:
- user.update.self

#### Naming Convention
```text
<resource>.<action>
```
Examples: user.view, user.create, user.update, user.delete
Stored in the permissions table.

## Data Model

```text 
users
  └── user_role
        └── roles
              └── role_permission
                    └── permissions
```
- Users can have multiple roles
- Roles can have multiple permissions
- Permissions are never assigned directly to users

## Authorization Flow

```text
[API Request]
      ↓
[Authentication]
      ↓
[Permission Middleware]
      ↓
[Load User Roles]
      ↓
[Aggregate Permissions]
      ↓
[Permission Match?]
   ├─ Yes → Controller
   └─ No  → 403 Forbidden
```

## Middleware Usage

### Route-Level Enforcement
```text
Route::get('/users')
    ->middleware('permission:user.view');
```

### Middleware Behavior

- Validates authenticated user
- Aggregates permissions via roles
- Blocks unauthorized requests with standardized API errors

## Gate Integration

The RBAC module integrates with Laravel Gates using a global override:
```text
Gate::before(function ($user, $ability) {
    return $user->hasPermission($ability) ?: null;
});
```
This enables permission checks anywhere in the application:
```text
Gate::authorize('user.create');
```
## User Model Integration
The User model remains owned by the User module.

RBAC integration is done via relationships:
- roles()
- permissions()
- hasPermission(string $permission)

This ensures clean module boundaries and avoids circular dependencies.

## Database Ownership

```table
Table	Owner
users	User Module
roles	RBAC Module
permissions	RBAC Module
pivots	RBAC Module
```

## Seeders
Seeders are maintained in: database/seeders/
They:
- Create base roles
- Create permissions
- Assign permissions to roles
- Bootstrap administrative access

Seeders are idempotent and CI/CD safe.

## CI/CD Compatibility

- Deterministic migrations
- Idempotent seeders
- Safe for migrate --seed
- No environment-specific logic

## Security & Audit Notes

- Authorization is enforced at middleware and Gate level
- No authorization logic exists in controllers
- Permission changes are tracked via migrations and seeders
- Suitable for SOC2 / ISO-style audits

## Non-Goals

- UI-based role management
- Hardcoded role checks
- Direct permission assignment to users

## Extensibility
Designed to support:

- Multi-role users
- ERP modules
- Feature-based permissions
- Policy-based authorization
- Multi-tenant systems (future)

## Ownership

- Maintainer: Backend Team
- Review Required: Yes
- Breaking Changes: Not allowed without RFC