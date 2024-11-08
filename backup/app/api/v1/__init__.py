from fastapi import APIRouter
from .endpoints import auth, graphs, deployments

api_router = APIRouter()
api_router.include_router(auth.router, tags=["auth"])
api_router.include_router(graphs.router, prefix="/graphs", tags=["graphs"])
api_router.include_router(deployments.router, prefix="/deployments", tags=["deployments"])
