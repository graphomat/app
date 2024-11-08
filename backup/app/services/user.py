from sqlalchemy.orm import Session
from typing import Optional
from ..core.security import get_password_hash, verify_password
from ..schemas.user import UserCreate, User

class UserService:
    @staticmethod
    async def get_by_email(db: Session, *, email: str) -> Optional[User]:
        # TODO: Implement actual database query
        return None

    @staticmethod
    async def create(db: Session, *, obj_in: UserCreate) -> User:
        # TODO: Implement actual database creation
        db_obj = User(
            email=obj_in.email,
            hashed_password=get_password_hash(obj_in.password),
            is_active=True,
            is_admin=False
        )
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
