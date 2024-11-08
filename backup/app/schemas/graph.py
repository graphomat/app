from pydantic import BaseModel, Field
from typing import Optional, Dict
from enum import Enum

class GraphStatus(str, Enum):
    DRAFT = "draft"
    ACTIVE = "active"
    ARCHIVED = "archived"

class GraphBase(BaseModel):
    title: str = Field(..., description="The title of the graph")
    description: Optional[str] = Field(None, description="Optional description of the graph")
    status: GraphStatus = Field(default=GraphStatus.DRAFT, description="Current status of the graph")
    config: Optional[Dict] = Field(default={}, description="Optional configuration for the graph")

class GraphCreate(GraphBase):
    pass

class GraphUpdate(BaseModel):
    title: Optional[str] = None
    description: Optional[str] = None
    status: Optional[GraphStatus] = None
    config: Optional[Dict] = None

class Graph(GraphBase):
    id: int
    user_id: int

    class Config:
        from_attributes = True
        json_schema_extra = {
            "example": {
                "id": 1,
                "title": "My Graph",
                "description": "A sample graph",
                "status": "draft",
                "config": {},
                "user_id": 1
            }
        }
