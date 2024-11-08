# GraphOMAT Project Documentation

## Overview

GraphOMAT is a graph management system consisting of two main components:
- **GraphOMAT Core**: A FastAPI-based service for graph management and deployment
- **Backup System**: A complementary service providing data persistence and backup functionality

## System Architecture

### Backend Services

Both services are built using:
- FastAPI for REST API implementation
- SQLAlchemy for database ORM
- Pydantic for data validation
- JWT-based authentication

### Database Schema

#### Graph Model
- `id`: Unique identifier
- `title`: Graph title (indexed)
- `description`: Optional description
- `status`: Graph state (DRAFT/ACTIVE/ARCHIVED)
- `config`: JSON configuration
- `user_id`: Foreign key to users table

## API Documentation

### Authentication Endpoints

- `POST /api/v1/auth/login`: User authentication
- `POST /api/v1/auth/signup`: User registration

### Graph Management Endpoints

#### GET /api/v1/graphs/
Lists all graphs for the authenticated user.

Query Parameters:
- `skip`: Pagination offset (default: 0)
- `limit`: Maximum number of records (default: 100)
- `status`: Filter by graph status

Response: List of Graph objects

#### POST /api/v1/graphs/
Creates a new graph.

Request Body:
```json
{
    "title": "string",
    "description": "string",
    "config": {}
}
```

#### GET /api/v1/graphs/{graph_id}
Retrieves a specific graph by ID.

#### PUT /api/v1/graphs/{graph_id}
Updates an existing graph.

#### DELETE /api/v1/graphs/{graph_id}
Deletes a graph.

### Deployment Endpoints

- `POST /api/v1/deployments/`: Create new deployment
- `GET /api/v1/deployments/`: List deployments
- `GET /api/v1/deployments/{id}`: Get deployment details

## Security

- JWT-based authentication
- Token expiration: 30 minutes
- Role-based access control
- Per-user data isolation

## Setup Instructions

1. Install dependencies:
```bash
pip install -r requirements.txt
```

2. Configure environment variables:
```bash
PROJECT_NAME=GRAPHOMAT
API_V1_STR=/api/v1
SECRET_KEY=your-secret-key
DATABASE_URL=sqlite:///./sql_app.db
```

3. Initialize database:
```bash
python init_db_runner.py
```

4. Start the server:
```bash
python run.py
```

## Development

### Testing
Tests are written using pytest. Run tests with:
```bash
pytest
```

### Project Structure
```
app/
├── api/
│   └── v1/
│       └── endpoints/
│           ├── auth.py
│           ├── graphs.py
│           └── deployments.py
├── core/
│   ├── config.py
│   └── security.py
├── models/
│   ├── user.py
│   └── graph.py
├── schemas/
│   └── graph.py
└── services/
    └── graph.py
```

## Error Handling

The API uses standard HTTP status codes:
- 200: Success
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 500: Internal Server Error

All error responses include a detail message explaining the error.

## Logging

The system implements comprehensive logging:
- Request logging
- Error tracking
- User actions
- System events

Logs include timestamp, user ID, action type, and relevant details for debugging and audit purposes.
