# Backup System Documentation

## Overview

The Backup System is a complementary service to GraphOMAT that provides data persistence, versioning, and backup functionality for graph data. It ensures data durability and enables recovery scenarios.

## Features

- Automated graph backups
- Version history
- Point-in-time recovery
- User-specific backup policies
- Backup status monitoring

## System Architecture

### Components

- FastAPI backend service
- SQLite database (configurable)
- Authentication service
- Backup service layer

### Database Schema

#### Graph Backups
- Inherits base graph structure
- Additional metadata for versioning
- Backup timestamps
- Version tracking
- Status information

## API Endpoints

### Graph Management

#### GET /api/v1/graphs/
Retrieves all graphs for the authenticated user with optional filtering:
- Status filtering
- Pagination support
- Version history access

#### POST /api/v1/graphs/
Creates a new graph with automatic backup initialization:
```json
{
    "title": "string",
    "description": "string",
    "config": {},
    "status": "draft"
}
```

#### PUT /api/v1/graphs/{graph_id}
Updates a graph while maintaining version history:
- Automatic version creation
- Configurable backup retention
- Metadata updates

#### DELETE /api/v1/graphs/{graph_id}
Soft deletion with retention policy:
- Configurable retention period
- Recovery options
- Audit logging

## Authentication & Security

- JWT-based authentication
- Role-based access control
- Per-user isolation
- Secure backup storage

## Setup Instructions

1. Install development dependencies:
```bash
pip install -r requirements-dev.txt
```

2. Install production dependencies:
```bash
pip install -r requirements.txt
```

3. Initialize the database:
```bash
python init_db_runner.py
```

4. Run the service:
```bash
python run.py
```

## Testing

The project includes comprehensive test coverage:

```bash
pytest tests/
```

Key test areas:
- API endpoint functionality
- Authentication flows
- Backup operations
- Data integrity
- Error handling

## Error Handling

Standard HTTP status codes with detailed error messages:
- 400: Invalid request format
- 401: Authentication required
- 403: Insufficient permissions
- 404: Resource not found
- 500: Internal server error

## Logging

Comprehensive logging system:
- Request/response logging
- Error tracking
- Backup operation logging
- Security events
- Performance metrics

## Development Guidelines

1. Code Style
   - Follow PEP 8
   - Use type hints
   - Document all functions
   - Maintain test coverage

2. Git Workflow
   - Feature branches
   - Pull request reviews
   - CI/CD integration
   - Version tagging

3. Testing
   - Unit tests required
   - Integration tests for APIs
   - Performance testing
   - Security testing

## Configuration

Environment variables:
```bash
DATABASE_URL=sqlite:///./workflow.db
SECRET_KEY=your-secret-key
API_V1_STR=/api/v1
PROJECT_NAME=GRAPHOMAT-BACKUP
```

## Monitoring

The system provides monitoring endpoints for:
- Service health
- Backup status
- Storage usage
- Performance metrics
- Error rates
