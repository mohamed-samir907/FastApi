from typing import Optional
from fastapi import FastAPI
import json

app = FastAPI()

@app.get("/")
def index():
    file = open('todos.json')
    data = json.load(file)
    file.close()
    
    return data

@app.get('/page1')
def page1():
    return {
        "page": "Page 1"
    }