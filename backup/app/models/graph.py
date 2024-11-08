# File: app/models/graph.py
from sqlalchemy import Column, Integer, String, JSON, Enum, DateTime, ForeignKey
from sqlalchemy.orm import relationship
from ..db.base import Base
from datetime import datetime
import enum

class GraphStatus(str, enum.Enum):
    DRAFT = "draft"
    READY = "ready"
    DEPLOYING = "deploying"
    DEPLOYED = "deployed"
    ERROR = "error"

class Graph(Base):
    __tablename__ = "graphs"

    id = Column(Integer, primary_key=True, index=True)
    name = Column(String, index=True)
    nodes = Column(JSON)
    edges = Column(JSON)
    status = Column(Enum(GraphStatus), default=GraphStatus.DRAFT)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    owner_id = Column(Integer, ForeignKey("users.id"))

    owner = relationship("User", back_populates="graphs")
    deployments = relationship("Deployment", back_populates="graph")

# File: app/api/v1/endpoints/graphs.py

# File: app/services/graph_deployment.py
