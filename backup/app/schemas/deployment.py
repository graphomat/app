from pydantic import BaseModel
from typing import Optional, List, Dict
from enum import Enum
from datetime import datetime

class DeploymentStatus(str, Enum):
    PENDING = "pending"
    RUNNING = "running"
    COMPLETED = "completed"
    FAILED = "failed"
    CANCELLED = "cancelled"

class DeploymentBase(BaseModel):
    graph_id: int
    status: DeploymentStatus = DeploymentStatus.PENDING
    config: Optional[Dict] = {}

class DeploymentCreate(DeploymentBase):
    pass

class Deployment(DeploymentBase):
    id: int
    user_id: int
    created_at: datetime
    updated_at: datetime
    completed_at: Optional[datetime] = None

    class Config:
        from_attributes = True

class DeploymentLog(BaseModel):
    deployment_id: int
    level: str
    message: str
    timestamp: datetime

    class Config:
        from_attributes = True

class DeploymentWithLogs(Deployment):
    logs: List[DeploymentLog] = []
