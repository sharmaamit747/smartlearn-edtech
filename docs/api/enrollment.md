# Enrollment API
This API allows an authenticated users to enroll in a course.
The enrollment service validates course availability, prevent duplicate enrollments, and triggres post-enrollment notifications asyncronously.

## POST api/enrollments

### Headers 
Autherization: Bearer <JWT_TOKEN>
Content-type: application/JSON
Idempotency-key: <unique-key>

### Request Body
```json
{
  "courseId": "COURSE_123"
}
```

### Success response - 201 Created
```json
{
  "enrollmentId": "ENROLL_456",
  "courseId": "COURSE_123",
  "userId": "USER_789",
  "status": "ENROLLED",
  "enrolledAt": "2026-01-10T10:30:00Z"
}
```

### 401 Unauthorized
```json
{
  "errorCode": "AUTH_401",
  "message": "Unauthorized access"
}
```

### 409 Conflict
```json
{
  "errorCode": "ENROLL_409",
  "message": "User already enrolled in this course"
}
```

### 400 Bad Request
```json
{
    "errorcode": "ENROLL_400",
    "message": "Course is full or Inactive"
}
```

### 403 Forbidden
```json
{
  "errorCode": "SUB_403",
  "message": "Active subscription required"
}
```

### Internal flow
1. API Gateway validate JWT
2. Enrollment Service checks user entitlement via Subscription Service
3. Course service validates course status 
4. Enrollment record is saved
5. Enrollment event is published to Notification service

## Design Notes
- Enrollment service enforce Idempotency 
- Course validation is delegated to Course Service
- Notification processing is asyncronous
- Standerized error responses are used across services

