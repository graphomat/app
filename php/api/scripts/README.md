# User and API Token Management

This directory contains scripts for managing users and API tokens for the DBT Unity application.

## Create User Script

The `create_user.php` script provides functionality to:
1. Create new user accounts
2. Generate API tokens for existing users
3. Automatically handle database schema updates

## Usage

### Create a New User

To create a new user with an API token:

```bash
php create_user.php --action=create --username=user1 --password=pass1
```

Example:
```bash
php create_user.php --action=create --username=api_user --password=secure_password123
```

This will:
- Create a new user account
- Generate an API token
- Set token expiration (30 days by default)
- Display the token and expiration date

### Generate New Token

To generate a new API token for an existing user:

```bash
php create_user.php --action=token --username=your_username
```

Example:
```bash
php create_user.php --action=token --username=api_user
```

This will:
- Generate a new API token
- Update token expiration
- Display the new token and expiration date

## API Token Usage

Once you have an API token, use it in your API requests:

```bash
curl -H "Authorization: Bearer your_api_token" http://your-api-endpoint
```

Example:
```bash
curl -H "Authorization: Bearer abc123..." http://localhost/graphomat/app/php/api/content
```

## Security Notes

1. Store API tokens securely
2. Never share tokens in public repositories
3. Regenerate tokens if compromised
4. Tokens expire after 30 days by default

## Database Schema

The script manages the following user table schema:

```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    api_token TEXT,
    token_expiry DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## Troubleshooting

1. If you get "Permission denied":
   ```bash
   chmod +x create_user.php
   ```

2. If database connection fails:
   - Check database file permissions
   - Verify database path in config

3. If token generation fails:
   - Ensure user exists
   - Check database write permissions
   - Verify PHP has sufficient entropy for random_bytes()
