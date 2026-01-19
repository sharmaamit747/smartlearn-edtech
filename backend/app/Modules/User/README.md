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
