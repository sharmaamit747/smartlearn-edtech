# Sprint-5: Async, Reliability & Observability

## Objective
Improve system resilience by introducing queue retry strategies,
failure handling, async notifications, and observability.

## Why This Sprint
Sprint-4 optimized performance.
Sprint-5 ensures the system survives failures gracefully.

## Key Outcomes
- Redis queue retry & failure strategy
- Async notification pipeline
- Safer cache invalidation
- Production-grade observability

### Enrollment Lifecycle (Sprint-5)

Controller
 → Domain Event
 → Multiple Async Listeners
    → Cache Invalidation
    → Notification
    → Analytics (future)

All listeners are queued and retryable.

### Queue Strategy

Driver: Redis  
Retry attempts: 5  
Backoff: 10s  
Failed jobs stored in DB

Failure does not block API response.

### Ops Commands

php artisan queue:failed
php artisan queue:retry all
php artisan queue:flush
php artisan queue:restart

Health endpoint:
/up

Used for:
- Docker healthchecks
- Load balancer probes
- Monitoring systems
