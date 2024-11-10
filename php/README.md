# PHP Web Application with Docker

This project includes a PHP web application with a main site and admin panel, containerized using Docker and including automated tests.

## Requirements

- Docker
- Docker Compose

## Quick Installation

The easiest way to install the application is using the installation script:

```bash
sudo ./install.sh
```

The installation script will:
1. Check and install required dependencies (Docker, Docker Compose)
2. Create necessary directories and set permissions
3. Set up environment configuration
4. Initialize the database with schema
5. Build and start Docker containers
6. Create a default admin user
7. Perform final checks

After installation, you'll receive:
- Application URL
- Admin panel credentials
- Security recommendations

## Manual Installation

If you prefer to install manually:

1. Clone the repository
2. Navigate to the project directory
3. Copy the environment file:
```bash
cp .env.example .env
```
4. Create necessary directories:
```bash
mkdir -p data uploads/documents uploads/images uploads/other
```
5. Set proper permissions:
```bash
sudo chown -R www-data:www-data data uploads
sudo chmod -R 755 data uploads
```
6. Initialize the database:
```bash
sqlite3 data/database.sqlite < ../schema.sql
```
7. Build and start containers:
```bash
docker-compose up -d --build
```

## Environment Configuration

The application uses environment variables for configuration. These are stored in the `.env` file. A template is provided in `.env.example`. Key configuration options include:

- `APP_ENV`: Application environment (development/production)
- `APP_DEBUG`: Enable/disable debug mode
- `APP_URL`: Application URL
- `DB_DATABASE`: SQLite database path
- `UPLOAD_PATH`: Path for file uploads
- Various security and session configurations

## Running Tests

The project includes automated tests for both the main site and admin panel. To run the tests:

```bash
./run_tests.sh
```

This script will:
1. Ensure the containers are running
2. Execute the test suite
3. Display the test results in a readable format

## Project Structure

- `/` - Main application files
- `/admin` - Admin panel files
- `/api` - API endpoints
- `/tests` - Automated tests
  - `/tests/MainSite` - Tests for the main website
  - `/tests/Admin` - Tests for the admin panel
- `/config` - Configuration files
  - `env.php` - Environment configuration handler
  - `Database.php` - Database connection manager
- `/data` - SQLite database files (created by Docker)

## Docker Configuration

- `Dockerfile` - Contains the PHP environment setup with Apache and required extensions
- `docker-compose.yml` - Defines the service configuration and environment variables
- The application runs on PHP 8.2 with Apache
- SQLite is used as the database
- All necessary PHP extensions are included in the Docker image

## Post-Installation Security Steps

After installation, make sure to:

1. Change the default admin password immediately
2. Update the APP_KEY in .env
3. Set secure values for SESSION_LIFETIME and COOKIE_LIFETIME
4. Configure proper mail settings if needed
5. Set APP_DEBUG=false in production
6. Review and secure file permissions
7. Configure SSL/TLS in production

## Development

To make changes to the application:

1. Modify the source files as needed
2. The changes will be immediately reflected due to volume mounting
3. Run the tests to ensure nothing is broken
4. Rebuild the container if you modify the Dockerfile:
```bash
docker-compose up -d --build
```

## Environment Variables

Important environment variables and their purposes:

### Application
- `APP_NAME`: Name of the application
- `APP_ENV`: Current environment (development/production)
- `APP_DEBUG`: Enable debug mode
- `APP_URL`: Base URL of the application

### Database
- `DB_CONNECTION`: Database type (sqlite)
- `DB_DATABASE`: Path to SQLite database file

### File Uploads
- `UPLOAD_PATH`: Base upload directory
- `DOCUMENTS_PATH`: Documents upload directory
- `IMAGES_PATH`: Images upload directory
- `OTHER_PATH`: Other files upload directory

### Security
- `SESSION_DRIVER`: Session storage driver
- `SESSION_LIFETIME`: Session lifetime in minutes
- `COOKIE_LIFETIME`: Cookie lifetime in minutes

### Admin Panel
- `ADMIN_PATH`: Admin panel URL path
- `ADMIN_SESSION_LIFETIME`: Admin session duration

### API
- `API_PATH`: API URL path
- `API_VERSION`: API version number

## Troubleshooting

If you encounter issues during installation:

1. Check Docker logs:
```bash
docker-compose logs
```

2. Verify permissions:
```bash
ls -la data uploads
```

3. Check database initialization:
```bash
sqlite3 data/database.sqlite ".tables"
```

4. Ensure all required ports are available:
```bash
netstat -tulpn | grep 8080
