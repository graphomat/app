
# File: app/schemas/graph.py
from pydantic import BaseModel
from typing import List, Dict, Any, Optional
from datetime import datetime
from .common import GraphStatus

class NodeBase(BaseModel):
    type: str
    position: Dict[str, float]
    data: Dict[str, Any]

class EdgeBase(BaseModel):
    source: str
    target: str
    type: str

class GraphCreate(BaseModel):
    name: str
    nodes: List[NodeBase]
    edges: List[EdgeBase]

class Graph(GraphCreate):
    id: int
    status: GraphStatus
    created_at: datetime
    updated_at: datetime
    owner_id: int

    class Config:
        from_attributes = True
