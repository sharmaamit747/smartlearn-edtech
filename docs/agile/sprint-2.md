# Sprint 2 – User, Course & Enrollment APIs

## Sprint Goal
Build RBAC-enforced User, Course, and Enrollment APIs with
production-grade backend practices, Docker readiness, and CI stability.

This sprint focuses on **real business logic** and **job-ready backend skills**.

---

## Sprint Duration
Start Date: <tomorrow’s date>  
End Date: <+5 days>


---

## Sprint Scope
- User CRUD APIs (RBAC-enforced)
- Course management APIs
- Enrollment workflows
- Docker setup for local development
- API documentation
- CI/CD stability

---

## Sprint Backlog

### User Management
- User CRUD APIs
- User status management
- RBAC enforcement

### Course Module
- Course CRUD APIs
- Publish / unpublish workflow
- Ownership validation

### Enrollment
- Student enrollment APIs
- Instructor & admin views

### DevOps
- Dockerfile
- docker-compose
- Environment consistency

---

## Git & Workflow Rules
- Base branch: develop
- Feature branches: feature/*
- One issue = one feature branch
- Daily commits & pushes
- CI must pass before merge
- No direct commits to main

---

## Definition of Done (DoD)
- All APIs secured with RBAC
- CI green
- Docker runs locally
- Documentation updated
- Code merged to main
- Release tagged (v1.1.0)

---

## Daily Plan (High-Level)

## Daily Plan (5-Day Sprint)

### Day 1 – User List & Create APIs
- Implemented GET /api/v1/users with pagination
- Implemented POST /api/v1/users with RBAC enforcement
- Added FormRequest validation and service layer
- Added feature & unit tests
- CI pipeline validated (green)

Day 2:
- User update, delete
- Status enable/disable
- Pagination & filters

Day 3:
- Course CRUD APIs
- Ownership validation

Day 4:
- Enrollment APIs
- Instructor/Admin views

Day 5:
- Docker setup
- Cleanup, docs, sprint review

---

## Sprint Status
Status: Planned  
Release Target: v1.1.0  
Branch Strategy: feature → develop → main
