# Product Requirement Document

## Product Name
Smart Learn - EdTech Platform

## Document Version
v1.0

## Prepared By
Amit Kumar

## Date
01-02-2026

## 1. Product Overview
Smart Learn is a Web-based EdTech Platform that allows instructors to create and publish online courses, and enable students to enroll, learn and track their progress.
The Project is designed to be scalable, secure and easy to maintain, using modern technologies and a microservices-based architecture.

## 2. Goals and Objectives

### Goals
- Provide a simple and reliable platform for online learning
- Enable Instructors to manage courses easily
- Allow students to track learning progress
- Ensure System scalabilty for future growth

###  Objectives
- Support user Authentication with role-based access(Student, Instructor)
- Allow course creation, publishing and enrollment
- Track course progress at a per-user level
- Send email notifications for important events

## 3. User Persons

### 1. Student
- Can Signup and login
- Can browse and enroll in courses
- Can view course content
- Can track learning progress

### 2. Instructor
- Can signup and login
- Can create and manage courses
- Can publish courses
- Can view student enrollment and progress

### 3. Admin
- Can manage users (students and instructors)
- Can approve or suspend courses
- Can monitor platform activity

### 4. Super Admin
- Has full system access
- Can manage admins
- Can configure system-level settings

## 4. In scope Features (Phase 1)

- User registration and login
- Role based access (Student, Instructor)
- Course creation and publishing
- Course enrollment
- Progress tracking
- Email notifications on enrollment
- Admin dashboard for user and course management
- Super Admin system-level controls

## 5. Out of Scope Features (Phase 1)
- Online payments
- Live video classes
- Mobile applications
- Certificates
- AI-based recommandations

## 6. Success metrices
- Number of registered users
- Course enrollment rate 
- Course completion percentage
- System uptime and performance 
- Email notification delivery success rate

## 7. Risks and mitigations
| Risk | Impact | Mitigation
|------|--------|-----------|
| Scope creepe | Delays delivery | Strict MVP defination | 
| High load in future | Performance issues | Microservices and Scaling | 
| Security vunerabilities | Data loss | Authentication and RBAC |
| Email failures | Poor UX | Retry and Logging mechanismsgit ||
