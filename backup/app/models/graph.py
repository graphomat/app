from sqlalchemy import Column, Integer, String, ForeignKey, JSON, Enum as SQLAlchemyEnum
from sqlalchemy.orm import relationship
from enum import Enum as PyEnum
from .user import Base

class GraphStatus(str, PyEnum):
    DRAFT = "draft"
    ACTIVE = "active"
    ARCHIVED = "archived"

class Graph(Base):
    __tablename__ = "graphs"

    id = Column(Integer, primary_key=True, index=True)
    title = Column(String, index=True)
    description = Column(String, nullable=True)
    status = Column(SQLAlchemyEnum(GraphStatus), default=GraphStatus.DRAFT)
    config = Column(JSON, nullable=True)
    user_id = Column(Integer, ForeignKey("users.id"))
    
    user = relationship("User", back_populates="graphs")

    class Config:
        from_attributes = True
