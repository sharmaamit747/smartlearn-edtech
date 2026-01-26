# User Module

## Responsibility
- User identity management
- User lifecycle (create, update, delete)
- Integration with RBAC

## Architecture
Controller → Service → Repository → Model

## Security
- RBAC enforced at route level
- No hardcoded role logic

## Endpoints

### GET /api/v1/users
List users (paginated).

**Permission:** `user.view`

**Response:**
- 200 OK
- Paginated list of users

---

### POST /api/v1/users
Create a new user.

**Permission:** `user.create`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "********"
}
```

## API Endpoints

```table
| Method | Endpoint | Permission |
|------|--------|-----------|
| GET | /api/v1/users | user.view |
| POST | /api/v1/users | user.create |
| PUT | /api/v1/users/{id} | user.update |
| PUT | /api/v1/users/{id}/self | user.update.self |
| DELETE | /api/v1/users/{id} | user.delete |
```

## Notes
- Users are soft deleted
- Self-update does not allow email/status changes
- RBAC is mandatory for all endpoints
