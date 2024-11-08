from fastapi import APIRouter
from .endpoints.auth import router as auth
from .endpoints.graphs import router as graphs
from .endpoints.deployments import router as deployments

api_router = APIRouter()
api_router.include_router(auth, prefix="/auth", tags=["auth"])
api_router.include_router(graphs, prefix="/graphs", tags=["graphs"])
api_router.include_router(deployments, prefix="/deployments", tags=["deployments"])
