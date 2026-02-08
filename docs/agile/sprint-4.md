# Sprint-4: Enrollment Lifecycle & Performance

## Summary
Sprint-4 focuses on decoupling enrollment side effects using events,
optimizing admin enrollment listing with Redis caching,
adding search capability, and protecting APIs via role-based rate limiting.

## Architecture Decisions
- Event-driven design for enrollment lifecycle
- Redis cache with tag-based invalidation
- SQL joins for search performance
- RBAC-aware throttling

## Performance Impact
- Admin enrollment listing: ~80% DB load reduction
- Consistent response times under load

## Security
- Role-based throttling
- Policy-based authorization

## Future Improvements
- Queue-based listeners
- Notification system
- ElasticSearch
