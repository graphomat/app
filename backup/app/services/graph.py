from sqlalchemy.orm import Session
from typing import List, Optional
from ..models.graph import Graph
from ..schemas.graph import GraphCreate, GraphUpdate

class GraphService:
    @staticmethod
    async def get(db: Session, id: int) -> Optional[Graph]:
        return db.query(Graph).filter(Graph.id == id).first()

    @staticmethod
    async def get_multi(
        db: Session,
        *,
        user_id: int,
        skip: int = 0,
        limit: int = 100,
        status: Optional[str] = None
    ) -> List[Graph]:
        query = db.query(Graph).filter(Graph.user_id == user_id)
        if status:
            query = query.filter(Graph.status == status)
        return query.offset(skip).limit(limit).all()

    @staticmethod
    async def create(
        db: Session,
        *,
        obj_in: GraphCreate,
        user_id: int
    ) -> Graph:
        db_obj = Graph(
            title=obj_in.title,
            description=obj_in.description,
            status=obj_in.status,
            config=obj_in.config,
            user_id=user_id
        )
        db.add(db_obj)
        db.commit()
        db.refresh(db_obj)
        return db_obj

    @staticmethod
    async def update(
        db: Session,
        *,
        db_obj: Graph,
        obj_in: GraphUpdate
    ) -> Graph:
        if obj_in.title is not None:
            db_obj.title = obj_in.title
        if obj_in.description is not None:
            db_obj.description = obj_in.description
        if obj_in.status is not None:
            db_obj.status = obj_in.status
        if obj_in.config is not None:
            db_obj.config = obj_in.config
        
        db.add(db_obj)
        db.commit()
        db.refresh(db_obj)
        return db_obj

    @staticmethod
    async def remove(db: Session, *, id: int) -> Graph:
        obj = db.query(Graph).get(id)
        db.delete(obj)
        db.commit()
        return obj
