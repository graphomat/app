from sqlalchemy.orm import Session
from typing import Optional
from ..core.hashing import get_password_hash, verify_password
from ..schemas.user import UserCreate
from ..models.user import User

class UserService:
    @staticmethod
    async def get(db: Session, id: int) -> Optional[User]:
        return db.query(User).filter(User.id == id).first()

    @staticmethod
    async def get_by_email(db: Session, *, email: str) -> Optional[User]:
        return db.query(User).filter(User.email == email).first()

    @staticmethod
    async def create(db: Session, *, obj_in: UserCreate) -> User:
        db_obj = User(
            email=obj_in.email,
            hashed_password=get_password_hash(obj_in.password),
            is_active=True,
            is_admin=False
        )
        db.add(db_obj)
        db.commit()
        db.refresh(db_obj)
        return db_obj

    @staticmethod
    async def authenticate(db: Session, *, email: str, password: str) -> Optional[User]:
        user = await UserService.get_by_email(db, email=email)
        if not user:
            return None
        if not verify_password(password, user.hashed_password):
            return None
        return user

    @staticmethod
    async def is_active(user: User) -> bool:
        return user.is_active

    @staticmethod
    async def is_admin(user: User) -> bool:
        return user.is_admin
