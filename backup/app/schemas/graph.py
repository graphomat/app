from pydantic import BaseModel
from typing import Optional, Dict
from enum import Enum

class GraphStatus(str, Enum):
    DRAFT = "draft"
    ACTIVE = "active"
    ARCHIVED = "archived"

class GraphBase(BaseModel):
    title: str
    description: Optional[str] = None
    status: GraphStatus = GraphStatus.DRAFT
    config: Optional[Dict] = {}

class GraphCreate(GraphBase):
    pass

class GraphUpdate(GraphBase):
    title: Optional[str] = None
    status: Optional[GraphStatus] = None

class Graph(GraphBase):
    id: int
    user_id: int

    class Config:
        from_attributes = True

class GraphWithDetails(Graph):
    deployments_count: int = 0
    latest_deployment: Optional[Dict] = None
