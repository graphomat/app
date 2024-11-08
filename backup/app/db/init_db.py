from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from ..core.config import settings
from ..models.user import Base as UserBase
from ..models.graph import Base as GraphBase

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
    print("Creating database tables...")
    init_db()
    print("Database tables created successfully!")
