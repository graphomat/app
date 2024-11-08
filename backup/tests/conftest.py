import pytest
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from fastapi.testclient import TestClient
import os
import sys
from datetime import datetime, timedelta

# Add the parent directory to Python path
current_dir = os.path.dirname(os.path.abspath(__file__))
parent_dir = os.path.dirname(current_dir)
sys.path.append(parent_dir)

from app.db.base import Base
from app.main import app
from app.core import security
from app.core import hashing
from app.models.user import User
from app.models.graph import Graph
from app.core.config import settings
from app.db.session import get_db

@pytest.fixture(scope="function")
def db_engine():
    """Create a new database engine for each test."""
    # Use a unique in-memory database for each test
    engine = create_engine(
        "sqlite:///:memory:",
        connect_args={"check_same_thread": False}
    )
    Base.metadata.create_all(bind=engine)
    yield engine
    Base.metadata.drop_all(bind=engine)

@pytest.fixture(scope="function")
def db_session(db_engine):
    """Creates a new database session for each test."""
    connection = db_engine.connect()
    transaction = connection.begin()
    TestingSessionLocal = sessionmaker(bind=connection)
    session = TestingSessionLocal()

    yield session

    session.close()
    transaction.rollback()
    connection.close()

@pytest.fixture(scope="function")
def client(db_session):
    """Create a test client with a clean database."""
    def override_get_db():
        try:
            yield db_session
        finally:
            pass

    # Clear any existing overrides
    app.dependency_overrides.clear()
    app.dependency_overrides[get_db] = override_get_db
    
    with TestClient(app) as test_client:
        yield test_client

    # Clear overrides after test
    app.dependency_overrides.clear()

@pytest.fixture(scope="function")
def test_user(db_session):
    """Creates a test user."""
    user = User(
        email="test@example.com",
        hashed_password=hashing.get_password_hash("testpassword"),
        is_active=True
    )
    db_session.add(user)
    db_session.commit()
    db_session.refresh(user)
    return user

@pytest.fixture(scope="function")
def test_token(test_user):
    """Creates a valid token for the test user."""
    return security.create_access_token(test_user.id)

@pytest.fixture(scope="function")
def authorized_client(client, test_token):
    """Creates a test client with authorization headers."""
    client.headers = {
        **client.headers,
        "Authorization": f"Bearer {test_token}"
    }
    return client

@pytest.fixture(scope="function")
def test_graph(db_session, test_user):
    """Creates a test graph."""
    graph = Graph(
        title="Test Graph",
        description="Test Description",
        status="draft",
        config={"test": "config"},
        user_id=test_user.id
    )
    db_session.add(graph)
    db_session.commit()
    db_session.refresh(graph)
    return graph
