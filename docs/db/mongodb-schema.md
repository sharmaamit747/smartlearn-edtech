# MongoDB collections - SmartLearn

## progress

Tracks learner progress across courses

Structure:
- user_id
- course_id
- completed_units[]
- completion_percentage
- last_accessed_at

## activity_logs

Stores system and user activities for audit/log

Structure:
- actor_id
- actor_type (user or system)
- action
- entity_type
- entity_id
- metadata {}
- created_at

## future_collections

### live_session
- course_id
- instructor_id
- schedule
- participants []


### quiz_attempts
- user_id
- quiz_id
- answers []
- score
- submitted_at

## Why MongoDB?

- High write frequency
- Schema flexibility
- Supports involvements learning formats
- Prevents relational DB bloat


