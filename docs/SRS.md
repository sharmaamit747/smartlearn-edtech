# Software Requirement Specification

## Product Name
SmartLearn - EdTech Platform

## Document version 
v1.0

## Prepared by
Amit Kumar

## Date
04-01-2026

## 1. System overview

SmartLearn is web-based EdTech Platform built using a microservice architecture. The system consists of multiple independent backend services developed using Laravel 12, and a Frontend application developed using React.
Each Backend service is responsible for a specific business capability and communicates with services using REST API's.
A frontend communicates with backend services through an API Gateway layer.

## 2. Architecture style

The application follows a microservices-based architecture with the following characterstics:
- Independent deployement of services
- Loose coupling between services
- Centralize Authentication and Autherization
- Scalable and fault-tolerated design

## 3. Technology stack

### Frontend
- React.js
- HTML5, CSS3
- Axios for API Communication

### Backend 
- Laravel 12
- PHP 8.x
- RESTfull API's

### Databases
- MySQL (Relational data such as users, courses, enrollments)
- MongoDB (Non-relation data such as logs and activity tracking)

### Devops and Tools
- Git & GitHub (Version Control)
- Docker (Containerization)
- GitHub actions (CI/CD)
- Ngnix (Reverse proxy)

## 4. Hign-Level system components

The SmartLearn platform is composed of the following backend microservices:

### 1. Authentication services
- Handles user registration and logic
- Manages authentication tokens
- Support role-based access control

### 2. User management service
- Manages user profiles
- Handles role assignments (Student, Instructor, Admin, Super Admin)

### 3. Course Management service
- Allows instructures to create and publish courses
- Manages course content and metadata

### 4. Enrollment service
- Handles course enrollment
- Maintains enrollment records

### 5. Progress tracking service
- Tracks user progress within progress
- Stores progress data per user

### 6. Notification service
- Sends email notifications for system events
- Handles retrices and logging

## 5. API Communication & Gateway Design

The SmartLearn frontend communicates with backend services through a centerlized API Gateway.

### API Gateway Responsibilities
- Remote requests to appropriate microservices
- Perform authentication and authorization checks 
- Handle request validation and rate limiting

### Communication flow
- Frontend -> API Gateway -> Backend microservice
- Backend services communicate with each other via REST APIs when required

All APIs follow REST standards and use JSON as the data exchange format.

## 6. Authentication & Authorization

### Authentication
- Users authenticate using email and password
- Authentication service issues JWT tokens upon successfull login
- Tokens are included in API requests for authentication

### Authorization
- Role-based access control (RBAC) is implemented
- Roles include Student, Instructor, Admin and SuperAdmin
- Each API endpoint validates user role and permissions

## 7. Data Management and Data Design

Each microservices manages its own data storage to ensure loose coupling.

### MySQL Usages
- User Data
- Course Data
- Enrollment Data
- Role and permission data

### MongoDB Usages
- Activity logs
- User progress event
- System audit logs

Data sharing between services is handeled via APIs rather than direct Database access

## 8. Non-functional requirements

### Performace 
- API response time should be under 300ms for standard request
- System should support concurrent users without degradation

### Security
- All APIs must be protected using JWT authentication 
- Sensetive data must be encrypted in transit using HTTPS
- Password must be securely hashed

### Availability and Scalability
- System should be highly available
- Services should support horizontal scaling
- Minimal downtime during deployements

## 9. Error Handling and Error

- All services must return standardized HTTP status codes
- Error responses should include meaningful error message
- Centralized logging should be implemented for all services
- Logs should capture request details, errors, and system events
- MongoDB will be used to store logs and audit data

## 10. Deployement and DevOps overview

- Each microservice will be containerized using Docker
- Services will be deployed independently
- CI/CD pipelines will be configured independently Github Actions
- Automated build, test, and deployment steps will be followed
- Nginx will act as a reverse proxy for routing requests
- Enviornment variables will be used for configuration management 