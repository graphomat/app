from fastapi import FastAPI, HTTPException, Depends, BackgroundTasks
from fastapi.security import OAuth2PasswordBearer
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
from .api import router as api_router

# Load environment variables
load_dotenv()

app = FastAPI(title="Graphomat API")
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")

# Include API router
app.include_router(api_router, prefix="/api")

# Rest of the code remains the same...
