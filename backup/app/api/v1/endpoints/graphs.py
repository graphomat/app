from fastapi import APIRouter, Depends, HTTPException, BackgroundTasks
from sqlalchemy.orm import Session
from typing import List
from ....core import security
from ....core.config import settings
from ....schemas.graph import GraphCreate, Graph
from ....models.graph import GraphStatus
from ....services.graph_deployment import GraphDeploymentService
from ....db.session import get_db

router = APIRouter(prefix="/graphs", tags=["graphs"])

@router.post("/", response_model=Graph)
async def create_graph(
        graph: GraphCreate,
        db: Session = Depends(get_db),
        current_user = Depends(security.get_current_user)
):
    db_graph = Graph(
        name=graph.name,
        nodes=graph.nodes.dict(),
        edges=graph.edges.dict(),
        owner_id=current_user.id
    )
    db.add(db_graph)
    db.commit()
    db.refresh(db_graph)
    return db_graph

@router.post("/{graph_id}/deploy")
async def deploy_graph(
        graph_id: int,
        background_tasks: BackgroundTasks,
        db: Session = Depends(get_db),
        current_user = Depends(security.get_current_user)
):
    graph = db.query(Graph).filter(Graph.id == graph_id).first()
    if not graph:
        raise HTTPException(status_code=404, detail="Graph not found")

    if graph.owner_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not authorized")

    deployment_service = GraphDeploymentService()
    background_tasks.add_task(
        deployment_service.deploy_graph,
        graph,
        db
    )

    graph.status = GraphStatus.DEPLOYING
    db.commit()

    return {"message": "Deployment started"}

@router.get("/{graph_id}/status")
async def get_graph_status(
        graph_id: int,
        db: Session = Depends(get_db),
        current_user = Depends(security.get_current_user)
):
    graph = db.query(Graph).filter(Graph.id == graph_id).first()
    if not graph:
        raise HTTPException(status_code=404, detail="Graph not found")

    if graph.owner_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not authorized")

    return {
        "status": graph.status,
        "updated_at": graph.updated_at
    }
