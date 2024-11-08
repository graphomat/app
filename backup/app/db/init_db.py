from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from ..core.config import settings
from .base import Base
from ..models import user, graph  # Import models to register them with Base

def init_db():
    # Create SQLAlchemy engine
    engine = create_engine(
        f"sqlite:///{settings.DB_PATH}",
        connect_args={"check_same_thread": False}  # Needed for SQLite
    )

    # Create all tables
    Base.metadata.create_all(bind=engine)

    # Create SessionLocal class
    SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

    return SessionLocal()

if __name__ == "__main__":
    print("Creating database tables...")
    init_db()
    print("Database tables created successfully!")
