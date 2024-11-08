#!/usr/bin/env python3
import os
import sys
import shutil
from pathlib import Path
import subprocess

class ProjectGenerator:
    def __init__(self, project_name):
        self.project_name = project_name
        self.base_dir = Path(project_name)
        self.env_content = '''# Server
DEBUG=True
SERVER_HOST=0.0.0.0
SERVER_PORT=8000
API_V1_STR=/api/v1
PROJECT_NAME={project_name}

# Security
SECRET_KEY=your-secret-key-here
ALGORITHM=HS256
ACCESS_TOKEN_EXPIRE_MINUTES=30

# Database
DATABASE_URL=sqlite:///./sql_app.db

# Email
SMTP_TLS=True
SMTP_PORT=587
SMTP_HOST=smtp.gmail.com
SMTP_USER=your-email@gmail.com
SMTP_PASSWORD=your-app-password
EMAILS_FROM_EMAIL=info@{project_name}.com
EMAILS_FROM_NAME={project_name}

# AWS (optional)
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_REGION=eu-west-1

# Monitoring
LOG_LEVEL=INFO
SENTRY_DSN=your-sentry-dsn
'''.format(project_name=project_name)

        self.requirements = '''fastapi==0.104.1
uvicorn==0.24.0
pydantic==2.4.2
python-jose[cryptography]==3.3.0
passlib[bcrypt]==1.7.4
python-dotenv==1.0.0
aiohttp==3.8.6
opencv-python==4.8.1.78
numpy==1.24.3
schedule==1.2.0
python-multipart==0.0.6
SQLAlchemy==2.0.23
aiosqlite==0.19.0
email-validator==2.1.0.post1
python-jose[cryptography]==3.3.0
PyJWT==2.8.0'''

        self.requirements_dev = '''pytest==7.4.3
pytest-asyncio==0.21.1
httpx==0.25.1
pytest-cov==4.1.0
black==23.10.1
flake8==6.1.0
mypy==1.7.0'''

        self.dockerfile = '''FROM python:3.9-slim

WORKDIR /app

COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000"]'''

        self.docker_compose = '''version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    env_file:
      - .env
    volumes:
      - .:/app'''

    def create_directory_structure(self):
        """Create the project directory structure"""
        directories = [
            'app/api/v1/endpoints',
            'app/core',
            'app/db',
            'app/models',
            'app/schemas',
            'app/services',
            'tests/api',
            'docker'
        ]

        for directory in directories:
            (self.base_dir / directory).mkdir(parents=True, exist_ok=True)
            (self.base_dir / directory / '__init__.py').touch()

    def create_main_app(self):
        """Create main FastAPI application file"""
        main_app = '''from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from .core.config import settings
from .api.v1.endpoints import auth, graphs, deployments

app = FastAPI(
    title=settings.PROJECT_NAME,
    openapi_url=f"{settings.API_V1_STR}/openapi.json"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Include routers
app.include_router(auth.router, prefix=settings.API_V1_STR)
app.include_router(graphs.router, prefix=settings.API_V1_STR)
app.include_router(deployments.router, prefix=settings.API_V1_STR)

@app.get("/")
def read_root():
    return {"message": "Welcome to GraphOMAT API"}'''

        with open(self.base_dir / 'app' / 'main.py', 'w') as f:
            f.write(main_app)

    def create_config(self):
        """Create configuration files"""
        config = '''from pydantic_settings import BaseSettings
from typing import Optional

class Settings(BaseSettings):
    PROJECT_NAME: str
    API_V1_STR: str = "/api/v1"
    SECRET_KEY: str
    ALGORITHM: str = "HS256"
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 30
    DATABASE_URL: str
    
    class Config:
        env_file = ".env"

settings = Settings()'''

        with open(self.base_dir / 'app' / 'core' / 'config.py', 'w') as f:
            f.write(config)

    def create_models(self):
        """Create database models"""
        models = '''from sqlalchemy import Column, Integer, String, DateTime, Boolean, ForeignKey
from sqlalchemy.orm import relationship
from ..db.base import Base
from datetime import datetime

class User(Base):
    __tablename__ = "users"

    id = Column(Integer, primary_key=True, index=True)
    email = Column(String, unique=True, index=True)
    hashed_password = Column(String)
    is_active = Column(Boolean, default=True)
    graphs = relationship("Graph", back_populates="owner")

class Graph(Base):
    __tablename__ = "graphs"

    id = Column(Integer, primary_key=True, index=True)
    title = Column(String, index=True)
    description = Column(String)
    owner_id = Column(Integer, ForeignKey("users.id"))
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    owner = relationship("User", back_populates="graphs")'''

        with open(self.base_dir / 'app' / 'models' / 'models.py', 'w') as f:
            f.write(models)

    def create_environment_files(self):
        """Create environment and requirement files"""
        with open(self.base_dir / '.env', 'w') as f:
            f.write(self.env_content)

        with open(self.base_dir / 'requirements.txt', 'w') as f:
            f.write(self.requirements)

        with open(self.base_dir / 'requirements-dev.txt', 'w') as f:
            f.write(self.requirements_dev)

    def create_docker_files(self):
        """Create Docker related files"""
        with open(self.base_dir / 'docker' / 'Dockerfile', 'w') as f:
            f.write(self.dockerfile)

        with open(self.base_dir / 'docker-compose.yml', 'w') as f:
            f.write(self.docker_compose)

    def create_api_endpoints(self):
        """Create API endpoint files"""
        endpoints = {
            'auth.py': '''from fastapi import APIRouter, Depends, HTTPException
from ..dependencies import get_current_user

router = APIRouter()

@router.post("/login")
async def login():
    return {"message": "Login endpoint"}''',

            'graphs.py': '''from fastapi import APIRouter, Depends
from ..dependencies import get_current_user

router = APIRouter()

@router.get("/graphs")
async def read_graphs():
    return {"message": "Get graphs endpoint"}''',

            'deployments.py': '''from fastapi import APIRouter, Depends
from ..dependencies import get_current_user

router = APIRouter()

@router.post("/deploy")
async def deploy_graph():
    return {"message": "Deploy graph endpoint"}'''
        }

        for filename, content in endpoints.items():
            with open(self.base_dir / 'app' / 'api' / 'v1' / 'endpoints' / filename, 'w') as f:
                f.write(content)

    def initialize_git(self):
        """Initialize git repository"""
        gitignore_content = '''__pycache__/
*.py[cod]
*$py.class
*.so
.Python
env/
build/
develop-eggs/
dist/
downloads/
eggs/
.eggs/
lib/
lib64/
parts/
sdist/
var/
*.egg-info/
.installed.cfg
*.egg
.env
.venv
venv/
ENV/
.idea/
.vscode/
*.sqlite'''

        with open(self.base_dir / '.gitignore', 'w') as f:
            f.write(gitignore_content)

        subprocess.run(['git', 'init'], cwd=self.base_dir)

    def create_project(self):
        """Create the entire project structure"""
        print(f"Creating project: {self.project_name}")

        self.create_directory_structure()
        self.create_main_app()
        self.create_config()
        self.create_models()
        self.create_environment_files()
        self.create_docker_files()
        self.create_api_endpoints()
        self.initialize_git()

        print("Project created successfully!")
        print(f"\nTo get started:")
        print(f"cd {self.project_name}")
        print("python -m venv venv")
        print("source venv/bin/activate  # Linux/Mac")
        print("pip install -r requirements.txt")
        print("uvicorn app.main:app --reload")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python generate_project.py project_name")
        sys.exit(1)

    generator = ProjectGenerator(sys.argv[1])
    generator.create_project()