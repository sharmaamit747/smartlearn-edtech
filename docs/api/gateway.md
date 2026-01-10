# API Gateway

This document defines all public-facing APIs exposed by the SmartLearn API Gateway. All client applications (Web & Mobile) communicate exclusively with the API Gateway. Internal microservice are not exposed directly.

## Common Request standard

### Base URL 
- /api

### Header 
- Authorization: Bearer <JWT_TOKEN>

### Content-type 
- Content-Type: application/json

## Aithentication APIs

### POST /api/auth/login
Authenticate users and returns JWT tokens

### POST /api/auth/register
Registers a new user

### POST /api/auth/refresh
Refreshes access token

## User APIs

### GET api/user/me
Returns logged in users profile

### PUT api/user/me
Updates logged in users profile

Authentication: Required

## Course APIs

### GET api/courses
Return list of all published courses

### GET api/courses/{courseId}
Returns course details

### POST api/courses
creats a new course
Role: Instructor/admin

### PUT api/courses/{courseId}
Updates course details
Role: Instructor/Admin

## Enrollment APIs

### POST api/enrollments
Enrolls a user into course

### GET api/enrollments/my
Retuens list of courses enrollment by user
Authentication: Required

## Progress APIs

### GET api/progress/{courseId}
Returns user progress for a course

### POST api/progress/{courseId}
Updates user progress

Authentication: Required

## Error Handling
All APIs returns a standard error response format.
Example:
```json
{
    "errorcode" : "AUTH_401",
    "message" : "Unautherized access"
}
```

Error Codes: 
400 – Business validation error
401 – Unauthorized
403 – Forbidden
409 – Conflict
500 – Internal server error

## Design Notes

- API Gateway handles authentication and routing only
- Business logic resides inside domain services
- Internal service APIs are not exposed publicly 