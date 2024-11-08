import pytest
from fastapi import status
from datetime import timedelta
from app.core import security

def test_login(client, test_user):
    """Test user login."""
    response = client.post(
        "/api/v1/auth/login",
        data={
            "username": "test@example.com",
            "password": "testpassword"
        }
    )
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert "access_token" in data
    assert data["token_type"] == "bearer"

def test_login_incorrect_password(client, test_user):
    """Test login with incorrect password."""
    response = client.post(
        "/api/v1/auth/login",
        data={
            "username": "test@example.com",
            "password": "wrongpassword"
        }
    )
    assert response.status_code == status.HTTP_401_UNAUTHORIZED

def test_login_nonexistent_user(client):
    """Test login with non-existent user."""
    response = client.post(
        "/api/v1/auth/login",
        data={
            "username": "nonexistent@example.com",
            "password": "testpassword"
        }
    )
    assert response.status_code == status.HTTP_401_UNAUTHORIZED

def test_get_current_user(authorized_client, test_user):
    """Test getting current user information."""
    response = authorized_client.get("/api/v1/auth/me")
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert data["email"] == test_user.email
    assert data["id"] == test_user.id
    assert "hashed_password" not in data

def test_get_current_user_unauthorized(client):
    """Test getting current user without authentication."""
    response = client.get("/api/v1/auth/me")
    assert response.status_code == status.HTTP_401_UNAUTHORIZED

def test_invalid_token(client):
    """Test using an invalid token."""
    client.headers = {"Authorization": "Bearer invalid_token"}
    response = client.get("/api/v1/auth/me")
    assert response.status_code == status.HTTP_401_UNAUTHORIZED

def test_expired_token(client, test_user):
    """Test using an expired token."""
    # Create an expired token
    expired_token = security.create_access_token(
        test_user.id,
        expires_delta=timedelta(seconds=-1)  # Token expired 1 second ago
    )
    client.headers = {"Authorization": f"Bearer {expired_token}"}
    response = client.get("/api/v1/auth/me")
    assert response.status_code == status.HTTP_401_UNAUTHORIZED
