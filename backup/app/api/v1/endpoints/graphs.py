from fastapi import APIRouter, Depends, HTTPException, BackgroundTasks, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from ....core.security import get_current_user
from ....schemas.graph import (
    Graph, 
    GraphCreate, 
    GraphUpdate, 
    GraphStatus,
    GraphWithDetails
)
from ....services.graph import GraphService
from ....db.session import get_db

router = APIRouter()

@router.get("/", response_model=List[Graph])
async def list_graphs(
    *,
    db: Session = Depends(get_db),
    current_user = Depends(get_current_user),
    skip: int = 0,
    limit: int = 100,
    status: Optional[GraphStatus] = None
) -> List[Graph]:
    """
    Retrieve graphs.
    """
    graphs = await GraphService.get_multi(
        db, 
        user_id=current_user.id,
        skip=skip, 
        limit=limit,
        status=status
    )
    return graphs

@router.post("/", response_model=Graph)
async def create_graph(
    *,
    db: Session = Depends(get_db),
    graph_in: GraphCreate,
    current_user = Depends(get_current_user)
) -> Graph:
    """
    Create new graph.
    """
    graph = await GraphService.create(
        db,
        obj_in=graph_in,
        user_id=current_user.id
    )
    return graph

@router.get("/{graph_id}", response_model=GraphWithDetails)
async def get_graph(
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    current_user = Depends(get_current_user)
) -> GraphWithDetails:
    """
    Get graph by ID.
    """
    graph = await GraphService.get(db, id=graph_id)
    if not graph:
        raise HTTPException(status_code=404, detail="Graph not found")
    if graph.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not enough permissions")
    return graph

@router.put("/{graph_id}", response_model=Graph)
async def update_graph(
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    graph_in: GraphUpdate,
    current_user = Depends(get_current_user)
) -> Graph:
    """
    Update graph.
    """
    graph = await GraphService.get(db, id=graph_id)
    if not graph:
        raise HTTPException(status_code=404, detail="Graph not found")
    if graph.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not enough permissions")
    
    graph = await GraphService.update(db, db_obj=graph, obj_in=graph_in)
    return graph

@router.delete("/{graph_id}")
async def delete_graph(
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    current_user = Depends(get_current_user)
) -> dict:
    """
    Delete graph.
    """
    graph = await GraphService.get(db, id=graph_id)
    if not graph:
        raise HTTPException(status_code=404, detail="Graph not found")
    if graph.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not enough permissions")
    
    await GraphService.remove(db, id=graph_id)
    return {"success": True}
