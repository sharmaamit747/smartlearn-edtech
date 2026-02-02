# Sprint-3 Documentation (FINAL)

## Sprint Name
**Sprint-3: Enrollment Listing APIs**

## Sprint Duration
**5 working days**

## Sprint Goal
Provide role-based enrollment listing APIs for:
- **Students** (their own enrollments)
- **Instructors** (enrollments in their courses)
- **Admins** (all enrollments)

This sprint focuses on **read-heavy APIs**, **authorization correctness**, and **performance safety**.

---

## Scope Definition

### In Scope
- Enrollment listing APIs
- Policy-based access control
- Pagination & filtering
- API documentation (Postman)
- Feature tests
- GitHub Project board updates

### Out of Scope
- Payments
- Progress tracking
- Audit logs (Sprint-4)
- Webhooks / queues

---

## User Stories

### Student
As a student, I want to view all courses I’m enrolled in, so I can track my learning.

### Instructor
As an instructor, I want to see enrollments for my courses, so I can monitor engagement.

### Admin
As an admin, I want to view all enrollments on the platform, so I can audit system usage.

---

## Authorization Matrix

| Role        | Endpoint                                | Access Rule                              |
|------------|------------------------------------------|------------------------------------------|
| Student     | `/enrollments/my`                       | Own enrollments only                     |
| Instructor  | `/courses/{course}/enrollments`         | Only courses created by instructor       |
| Admin       | `/admin/enrollments`                    | Full access                              |

Authorization will be enforced via:
- Policies
- RBAC permissions
- Query scoping

---

## API Specifications

### Student – My Enrollments
**GET** `/api/v1/enrollments/my`

#### Query Params
- `status` (optional)
- `page` (default: 1)
- `per_page` (default: 15)

#### Response
```json
{
  "data": [
    {
      "id": 1,
      "course_id": 10,
      "status": "ACTIVE",
      "enrolled_at": "2026-02-01T10:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 5
  }
}
```

### Instructor – Course Enrollments

**GET** `/api/v1/courses/{course}/enrollments`

#### Rules
- Instructor must own the course
- Admin access allowed

#### Response
```json
{
  "data": [
    {
      "user_id": 12,
      "status": "ACTIVE",
      "enrolled_at": "2026-02-01T10:00:00Z"
    }
  ]
}
```

### Admin – All Enrollments

**GET** `/api/v1/admin/enrollments`

#### Query Params
- user_id
- course_id
- status
- date_range

### Technical Design

#### Policy Methods (EnrollmentPolicy)

- viewAny(User $user)
- view(User $user, Enrollment $enrollment)
- viewCourseEnrollments(User $user, Course $course)

#### Query Scoping

- No raw DB access
- Repository / Service layer filtering
- Index-friendly queries

### Testing Strategy

#### Feature Tests
- Student sees only own enrollments
- Instructor cannot access other instructors’ courses
- Admin sees all enrollments
- Unauthorized access returns 403

#### Performance
- Pagination mandatory
- No N+1 queries
- Eager loading only when required

### Deliverables Checklist

- Routes
- Controller methods
- Policy updates
- Service methods
- Feature tests
- Postman updates
- Sprint-3 documentation
- Project board updated

### Definition of Done

- All APIs return correctly scoped data
- All tests pass
- Postman collection updated
- Documentation committed
- PR merged into develop

### Git Strategy
```bash
feature/enrollment-listing
→ PR
→ develop
```

### Day-wise Breakdown

#### Day 1
- Permissions
- Policy methods

#### Day 2
- Student listing API

#### Day 3
- Instructor + Admin listing APIs

#### Day 4
- Tests + edge cases

#### Day 5
- Postman updates
- Documentation
- Pull Request