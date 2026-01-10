# API Standards

## API versioning

All public APIs are versioned to avoid breakink changes.

Base Path: /api/v1

## Authentication

Authentication is handeled using JWT tokens by the Auth service

Header: 
Authorization: Bearer <JWT_TOKEN>

## Authorization (RBAC)

Access is controlled using role-based authorization

Roles:
- STUDENT
- INSTRUCTOR
- ADMIN
- SUPER ADMIN

Authorization decions are enforced at service level using JWT claims

## Common headers

Content-type: application-json

X-Request-Id: <unique-request-id>

Idempotency-key: <uuid> (required for POST APIs)

## Success Response format

```json
{
    "data": {},
    "message": "Operation successfull"
}
```

## Error response format

```json
{
    "traceId": "REQ_1234",
    "errorcode": "ENROLL_409",
    "message": "User already enrolled"
}
```

## HTTP status code policy

200 – OK  
201 – Created  
400 – Business validation error  
401 – Unauthorized  
403 – Forbidden  
409 – Conflict  
500 – Internal server error

## Logging and Traceability

- Each request is logged using X-Request-Id
- Errors iclude traceId to allow correlation across services
