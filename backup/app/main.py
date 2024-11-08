from fastapi import FastAPI, HTTPException, Depends, BackgroundTasks
from fastapi.security import OAuth2PasswordBearer
from fastapi.staticfiles import StaticFiles
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, HttpUrl
from typing import List, Optional, Dict
import asyncio
import aiohttp
import cv2
import numpy as np
from datetime import datetime
import os
import json
import sqlite3
import subprocess
import schedule
import threading
import logging
from dotenv import load_dotenv
import jwt
from email.message import EmailMessage
import smtplib
import time
import re
from urllib.parse import urlparse
from pathlib import Path
from .api import router as api_router

# Load environment variables
load_dotenv()

app = FastAPI(title="Graphomat API")

# Configure CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# OAuth2 configuration
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")

# Include API router
app.include_router(api_router, prefix="/api")

# Get the directory containing this file
current_dir = Path(__file__).parent.parent.parent
static_dir = current_dir

# Mount static files
app.mount("/", StaticFiles(directory=str(static_dir), html=True), name="static")
