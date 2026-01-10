# Core database entities

## User

Stores platform users and roles
- Platform users (Student, Instructor, Admin, Super Admin)
- Auth via JWT
- Linked to subscriptions and enrollments

## Role

Defines RBAC roles

## Course

Stores course metadata
- Created by instructor 
- Has metadata only (content stored elsewhere)

## Enrollment

Tracks which user is enrolled in which course
- Maps users to course
- Controlled by subscription entitlements

## SubscriptionPlan

Define access plans
- Define access rules
- No payment logic incuded

## UserSubscription

Tracks user entitlements
- Active plan per user
- Used by enrollment service

## Progress (MongoDB)

Tracks course progress
- Tracks lesson completion
- Flexible structure

## ActivityLog (MongoDB)

Stores user/system activity
- System and user actions
- Used for audit/debug

## Storage strategy

### MySQL
- User
- Role
- Course
- Enrollment
- SubscriptionPlan
- UserSubscription

### MongoDB
- Pgrgress
- ActivityLog
- Future: LiveClassSession, QuizAttempts

