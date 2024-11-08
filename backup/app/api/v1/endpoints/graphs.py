from fastapi import APIRouter, Depends, HTTPException, status, Request
from sqlalchemy.orm import Session
from typing import Any, List, Optional
import logging
from ....core import security
from ....schemas.graph import Graph, GraphCreate, GraphUpdate
from ....services.graph import GraphService
from ....models.user import User
from ....db.session import get_db

# Set up logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

router = APIRouter()

@router.get("/", response_model=List[Graph])
async def list_graphs(
    request: Request,
    db: Session = Depends(get_db),
    skip: int = 0,
    limit: int = 100,
    status: Optional[str] = None,
    current_user: User = Depends(security.get_current_user)
) -> Any:
    """
    Retrieve graphs.
    """
    logger.info(f"Listing graphs for user {current_user.id} with status {status}")
    try:
        graphs = await GraphService.get_multi(
            db,
            user_id=current_user.id,
            skip=skip,
            limit=limit,
            status=status
        )
        logger.info(f"Found {len(graphs)} graphs")
        return graphs
    except Exception as e:
        logger.error(f"Error listing graphs: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

@router.post("/", response_model=Graph)
async def create_graph(
    request: Request,
    *,
    db: Session = Depends(get_db),
    graph_in: GraphCreate,
    current_user: User = Depends(security.get_current_user)
) -> Any:
    """
    Create new graph.
    """
    logger.info(f"Creating graph for user {current_user.id}")
    logger.info(f"Graph data: {graph_in.dict()}")
    try:
        graph = await GraphService.create(
            db,
            obj_in=graph_in,
            user_id=current_user.id
        )
        logger.info(f"Created graph with id {graph.id}")
        return graph
    except Exception as e:
        logger.error(f"Error creating graph: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

@router.get("/{graph_id}", response_model=Graph)
async def get_graph(
    request: Request,
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    current_user: User = Depends(security.get_current_user)
) -> Any:
    """
    Get graph by ID.
    """
    logger.info(f"Getting graph {graph_id} for user {current_user.id}")
    try:
        graph = await GraphService.get(db, id=graph_id)
        if not graph:
            logger.warning(f"Graph {graph_id} not found")
            raise HTTPException(status_code=404, detail="Graph not found")
        if graph.user_id != current_user.id:
            logger.warning(f"User {current_user.id} attempted to access graph {graph_id} owned by user {graph.user_id}")
            raise HTTPException(status_code=403, detail="Not enough permissions")
        return graph
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error getting graph: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

@router.put("/{graph_id}", response_model=Graph)
async def update_graph(
    request: Request,
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    graph_in: GraphUpdate,
    current_user: User = Depends(security.get_current_user)
) -> Any:
    """
    Update graph.
    """
    logger.info(f"Updating graph {graph_id} for user {current_user.id}")
    logger.info(f"Update data: {graph_in.dict(exclude_unset=True)}")
    try:
        graph = await GraphService.get(db, id=graph_id)
        if not graph:
            logger.warning(f"Graph {graph_id} not found")
            raise HTTPException(status_code=404, detail="Graph not found")
        if graph.user_id != current_user.id:
            logger.warning(f"User {current_user.id} attempted to update graph {graph_id} owned by user {graph.user_id}")
            raise HTTPException(status_code=403, detail="Not enough permissions")
        graph = await GraphService.update(db, db_obj=graph, obj_in=graph_in)
        logger.info(f"Updated graph {graph_id}")
        return graph
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error updating graph: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

@router.delete("/{graph_id}", response_model=Graph)
async def delete_graph(
    request: Request,
    *,
    db: Session = Depends(get_db),
    graph_id: int,
    current_user: User = Depends(security.get_current_user)
) -> Any:
    """
    Delete graph.
    """
    logger.info(f"Deleting graph {graph_id} for user {current_user.id}")
    try:
        graph = await GraphService.get(db, id=graph_id)
        if not graph:
            logger.warning(f"Graph {graph_id} not found")
            raise HTTPException(status_code=404, detail="Graph not found")
        if graph.user_id != current_user.id:
            logger.warning(f"User {current_user.id} attempted to delete graph {graph_id} owned by user {graph.user_id}")
            raise HTTPException(status_code=403, detail="Not enough permissions")
        graph = await GraphService.remove(db, id=graph_id)
        logger.info(f"Deleted graph {graph_id}")
        return graph
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error deleting graph: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))
