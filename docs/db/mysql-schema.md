# MySQL Schema Design – SmartLearn

## users

Purpose: Store all platform users (students, instructors, admins, super admin)

key fields:
- id (Primary Key)
- name
- email (Unique)
- password
- status (active, blocked)
- created_at
- updated_at

## roles

Purpose: Define system roles for RBAC

key fields:
- id (Primary Key)
- name (student, intructor, admin, super_admin)

## user_roles

Purpose: Maps user for one or more roles

key fields:
- user_id (Foreign key)
- role_id (Foreign key)

## course

Purpose: Store Course metadata

key fields:
- id (PK)
- title
- description
- instructor_id (FK -> users)
- status (draft, published)
- created_at

## enrollments

Purpose: Tracks User enrollments in courses

key fields:
- id (PK)
- user_id (FK -> users)
- course_id (FK -> courses)
- enrolled_at
- status

## subscription_plans

Purpose: Defines access plans (No payment)

key fields:
- id (PK)
- name
- access_level
- duration_days
- is_active

## user_subscriptions

Purpose: Tracks Active subscriptions per user

key fiels:
- id (PK)
- user_id (FK -> users)
- subscription_plan_id (FK -> subscription_plan)
- start_date
- end_date
- status

## Design notes
- Authentication and authorization are decoupled from business logic
- Subscription is entitlement-based, payment-agnostic
- Schema supports future services without notification
- MySQL used for consistency and transactional integrity