from fastapi import APIRouter, Depends, HTTPException, BackgroundTasks
from sqlalchemy.orm import Session
from typing import List, Optional
from ....core.security import get_current_user
from ....schemas.deployment import (
    Deployment,
    DeploymentCreate,
    DeploymentStatus,
    DeploymentWithLogs
)
from ....services.deployment import DeploymentService
from ....db.session import get_db

router = APIRouter()

@router.post("/{graph_id}/deploy", response_model=Deployment)
async def deploy_graph(
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    background_tasks: BackgroundTasks,
    current_user = Depends(get_current_user)
) -> Deployment:
    """
    Deploy a graph.
    """
    deployment = await DeploymentService.create_deployment(
        db, 
        graph_id=graph_id,
        user_id=current_user.id
    )
    
    background_tasks.add_task(
        DeploymentService.execute_deployment,
        db=db,
        deployment_id=deployment.id
    )
    
    return deployment

@router.get("/{graph_id}/deployments", response_model=List[Deployment])
async def list_deployments(
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    current_user = Depends(get_current_user),
    skip: int = 0,
    limit: int = 100,
    status: Optional[DeploymentStatus] = None
) -> List[Deployment]:
    """
    List deployments for a graph.
    """
    deployments = await DeploymentService.get_multi_by_graph(
        db,
        graph_id=graph_id,
        user_id=current_user.id,
        skip=skip,
        limit=limit,
        status=status
    )
    return deployments

@router.get("/deployments/{deployment_id}", response_model=DeploymentWithLogs)
async def get_deployment(
    *,
    db: Session = Depends(get_db),
    deployment_id: int,
    current_user = Depends(get_current_user)
) -> DeploymentWithLogs:
    """
    Get deployment details with logs.
    """
    deployment = await DeploymentService.get_with_logs(
        db,
        id=deployment_id,
        user_id=current_user.id
    )
    if not deployment:
        raise HTTPException(status_code=404, detail="Deployment not found")
    return deployment

@router.post("/deployments/{deployment_id}/cancel")
async def cancel_deployment(
    *,
    db: Session = Depends(get_db),
    deployment_id: int,
    current_user = Depends(get_current_user)
) -> dict:
    """
    Cancel ongoing deployment.
    """
    success = await DeploymentService.cancel_deployment(
        db,
        id=deployment_id,
        user_id=current_user.id
    )
    if not success:
        raise HTTPException(
            status_code=400,
            detail="Could not cancel deployment"
        )
    return {"success": True}
