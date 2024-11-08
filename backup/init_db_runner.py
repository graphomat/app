import os
import sys
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

# Add the parent directory to Python path
current_dir = os.path.dirname(os.path.abspath(__file__))
parent_dir = os.path.dirname(current_dir)
sys.path.append(parent_dir)

from backup.app.models.user import Base as UserBase
from backup.app.models.graph import Base as GraphBase
from backup.app.core.config import settings

def init_db():
    # Create SQLAlchemy engine
    engine = create_engine(
        f"sqlite:///{settings.DB_PATH}",
        connect_args={"check_same_thread": False}  # Needed for SQLite
    )

    # Create all tables
    UserBase.metadata.create_all(bind=engine)
    GraphBase.metadata.create_all(bind=engine)

    # Create SessionLocal class
    SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

    return SessionLocal()

if __name__ == "__main__":
    print("Initializing database...")
    init_db()
    print("Database initialized successfully!")
