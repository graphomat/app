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

# Load environment variables
load_dotenv()

app = FastAPI()
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")

# Models
class Step(BaseModel):
    protocol: str
    path: str
    params: Optional[Dict] = {}

class Flow(BaseModel):
    name: str
    steps: List[Step]
    created_by: str
    is_active: bool = True

class Process(BaseModel):
    name: str
    command: str
    filters: List[str]
    created_by: str
    is_system: bool = False

# Protocol Handlers
class ProtocolHandler:
    @staticmethod
    async def handle_rtsp(url: str, params: Dict) -> bytes:
        cap = cv2.VideoCapture(url)
        ret, frame = cap.read()
        cap.release()
        return frame if ret else None

    @staticmethod
    async def handle_file(path: str, params: Dict) -> str:
        if not os.path.exists(path):
            os.makedirs(path)
        return path

    @staticmethod
    async def handle_schedule(cron: str, params: Dict):
        schedule.every().hour.do(lambda: print(f"Scheduled task: {cron}"))
        return True

    @staticmethod
    async def handle_email(address: str, params: Dict):
        msg = EmailMessage()
        msg.set_content(params.get('content', ''))
        msg['Subject'] = params.get('subject', 'Workflow Notification')
        msg['From'] = os.getenv('EMAIL_FROM')
        msg['To'] = address

        with smtplib.SMTP(os.getenv('SMTP_HOST'), int(os.getenv('SMTP_PORT'))) as server:
            server.starttls()
            server.login(os.getenv('SMTP_USER'), os.getenv('SMTP_PASSWORD'))
            server.send_message(msg)

    @staticmethod
    async def handle_process(name: str, params: Dict):
        process = get_process(name)
        if process:
            cmd = process['command'].format(**params)
            result = subprocess.run(cmd, shell=True, capture_output=True, text=True)
            return result.stdout
        raise ValueError(f"Process {name} not found")

    @staticmethod
    async def handle_publish(topic: str, params: Dict):
        # Implement pub/sub system
        pass

    @staticmethod
    async def handle_subscribe(topic: str, params: Dict):
        # Implement pub/sub system
        pass

# Database operations
def init_db():
    conn = sqlite3.connect(os.getenv('DB_PATH'))
    c = conn.cursor()

    c.execute('''
        CREATE TABLE IF NOT EXISTS flows (
            id INTEGER PRIMARY KEY,
            name TEXT,
            steps TEXT,
            created_by TEXT,
            is_active BOOLEAN,
            created_at TIMESTAMP
        )
    ''')

    c.execute('''
        CREATE TABLE IF NOT EXISTS processes (
            id INTEGER PRIMARY KEY,
            name TEXT,
            command TEXT,
            filters TEXT,
            created_by TEXT,
            is_system BOOLEAN,
            created_at TIMESTAMP
        )
    ''')

    conn.commit()
    conn.close()

init_db()

# Authentication
async def get_current_user(token: str = Depends(oauth2_scheme)):
    try:
        payload = jwt.decode(
            token,
            os.getenv('JWT_SECRET'),
            algorithms=[os.getenv('JWT_ALGORITHM')]
        )
        return payload
    except jwt.JWTError:
        raise HTTPException(status_code=401)

# Flow operations
@app.post("/flows")
async def create_flow(flow: Flow, current_user: dict = Depends(get_current_user)):
    conn = sqlite3.connect(os.getenv('DB_PATH'))
    c = conn.cursor()

    c.execute('''
        INSERT INTO flows (name, steps, created_by, is_active, created_at)
        VALUES (?, ?, ?, ?, ?)
    ''', (
        flow.name,
        json.dumps([{"protocol": s.protocol, "path": s.path, "params": s.params} for s in flow.steps]),
        current_user['sub'],
        flow.is_active,
        datetime.now().isoformat()
    ))

    flow_id = c.lastrowid
    conn.commit()
    conn.close()

    return {"id": flow_id}

@app.get("/flows")
async def get_flows(current_user: dict = Depends(get_current_user)):
    conn = sqlite3.connect(os.getenv('DB_PATH'))
    c = conn.cursor()

    c.execute("SELECT * FROM flows WHERE created_by = ?", (current_user['sub'],))
    flows = [{
        "id": row[0],
        "name": row[1],
        "steps": json.loads(row[2]),
        "created_by": row[3],
        "is_active": row[4],
        "created_at": row[5]
    } for row in c.fetchall()]

    conn.close()
    return flows

# Process operations
@app.post("/processes")
async def create_process(
        process: Process,
        current_user: dict = Depends(get_current_user)
):
    if not current_user.get('is_admin'):
        raise HTTPException(status_code=403)

    conn = sqlite3.connect(os.getenv('DB_PATH'))
    c = conn.cursor()

    c.execute('''
        INSERT INTO processes (name, command, filters, created_by, is_system, created_at)
        VALUES (?, ?, ?, ?, ?, ?)
    ''', (
        process.name,
        process.command,
        json.dumps(process.filters),
        current_user['sub'],
        process.is_system,
        datetime.now().isoformat()
    ))

    process_id = c.lastrowid
    conn.commit()
    conn.close()

    return {"id": process_id}

# Workflow execution
async def execute_step(step: Step, context: Dict):
    protocol = step.protocol
    handler = getattr(ProtocolHandler, f"handle_{protocol}", None)

    if not handler:
        raise ValueError(f"Unsupported protocol: {protocol}")

    result = await handler(step.path, {**step.params, **context})
    return result

async def execute_flow(flow_id: int, context: Dict = None):
    if context is None:
        context = {}

    conn = sqlite3.connect(os.getenv('DB_PATH'))
    c = conn.cursor()

    c.execute("SELECT * FROM flows WHERE id = ?", (flow_id,))
    flow = c.fetchone()

    if not flow:
        raise ValueError(f"Flow {flow_id} not found")

    steps = json.loads(flow[2])

    for step in steps:
        try:
            result = await execute_step(Step(**step), context)
            context['last_result'] = result
        except Exception as e:
            logging.error(f"Error executing step: {e}")
            raise

    return context

@app.post("/flows/{flow_id}/execute")
async def trigger_flow(
        flow_id: int,
        background_tasks: BackgroundTasks,
        context: Dict = None,
        current_user: dict = Depends(get_current_user)
):
    background_tasks.add_task(execute_flow, flow_id, context)
    return {"status": "Flow execution started"}

# Schedule management
def run_scheduler():
    while True:
        schedule.run_pending()
        time.sleep(1)

scheduler_thread = threading.Thread(target=run_scheduler)
scheduler_thread.daemon = True
scheduler_thread.start()

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(
        "main:app",
        host=os.getenv('SERVER_HOST'),
        port=int(os.getenv('SERVER_PORT')),
        reload=bool(os.getenv('DEBUG'))
    )