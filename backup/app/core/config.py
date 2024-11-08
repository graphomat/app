from pydantic import BaseModel
from typing import Optional

class Settings(BaseModel):
    PROJECT_NAME: str = "Graphomat"
    API_V1_STR: str = "/api/v1"
    
    # Security
    JWT_SECRET: str = "your-secret-key-here"  # In production, use proper secret key
    JWT_ALGORITHM: str = "HS256"
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 60 * 24 * 8  # 8 days
    
    # Server
    SERVER_HOST: str = "0.0.0.0"
    SERVER_PORT: int = 8080
    DEBUG: bool = True
    
    # Database
    DB_PATH: str = "app.db"
    
    # Email
    EMAIL_FROM: Optional[str] = None
    SMTP_HOST: Optional[str] = None
    SMTP_PORT: Optional[int] = None
    SMTP_USER: Optional[str] = None
    SMTP_PASSWORD: Optional[str] = None

settings = Settings()
