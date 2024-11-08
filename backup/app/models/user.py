from sqlalchemy import Boolean, Column, Integer, String
from sqlalchemy.orm import relationship
from ..db.base import Base

class User(Base):
    __tablename__ = "users"

    id = Column(Integer, primary_key=True, index=True)
    email = Column(String, unique=True, index=True)
    hashed_password = Column(String)
    is_active = Column(Boolean, default=True)
    is_admin = Column(Boolean, default=False)

    graphs = relationship("Graph", back_populates="user", cascade="all, delete-orphan")

    class Config:
        from_attributes = True
