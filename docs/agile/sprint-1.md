# Sprint 1 – Architecture & Backend Foundation

## Sprint Goal
Establish a solid backend foundation for SmartLearn using a modular Laravel 12 architecture, standardized APIs, Role-Based Access Control (RBAC) planning and implementation, CI pipeline, and supporting documentation.

## Sprint Duration
Start Date: <today>
End Date: <+7 days>

## Sprint Backlog
- Define backend sprint scope & goals
- Set up Laravel modular architecture
- Define API standards & centralized error handling
- Implement RBAC (roles, permissions, middleware, gates)
- Prepare architecture & sequence diagrams
- Configure CI pipeline for backend validation
- Sprint documentation & review

## Definition of Done
- Code committed and merged into main branch
- CI pipeline passing successfully
- RBAC implemented and verified
- Documentation reviewed and approved
- Architecture decisions validated

## Status
- Sprint: Active
- Framework: Laravel 12
- Architecture: Modular Monolith

## Completed Issues
- Issue 1: Project setup & architecture
- Issue 2: Auth module (validation & API responses)
- Issue 3: CI pipeline setup
- Issue 4.1: User module skeleton
- Issue 4.1.5: RBAC planning & implementation

## In Progress
- Issue 4.2: User CRUD APIs (RBAC-Enforced)

## Key Decisions
- RBAC implemented before User CRUD
- Permissions-based authorization
- Modular architecture (User, Auth, Shared/RBAC)

## Daily Notes
Day 1:
- Sprint board created
- Milestone added
- CI pipeline added
- Basic Laravel 12 project setup verified

Day 2:
- Created domain-driven module folder structure for Auth, User, Course, and Shared layers
- Refactored Laravel 12 routing to comply with ApplicationBuilder constraints by loading module routes via routes/api.php
- Verified Laravel 12 routing setup with clean baseline route list
- Auth module API routes scaffolded (login, register)
- AuthController and AuthService skeletons created with clean separation of concerns

Day 3:
- Implemented request validation layer for Auth APIs using Laravel FormRequest
- Added standardized API response trait and base API exception handling

Day 4:
- Designed and finalized RBAC architecture
- Defined roles and permission matrix
- Implemented RBAC database schema: roles, permissions, role_permission (pivot), user_role (pivot)
- Implemented RBAC models, middleware, and Gate integration
- Integrated RBAC with Laravel 12 middleware registration via bootstrap/app.php
    
Day 5:
- Integrated RBAC relationships into User domain model
- Implemented permission-check middleware (permission:<slug>)
- Added RBAC seeders for roles and permissions
- Verified RBAC behavior using protected API routes
- Stabilized modular service providers
- Verified CI pipeline with migrations and seeders
- Updated project documentation for RBAC and User module
- Reviewed architecture for extensibility (ERP, Course, Enrollment)

