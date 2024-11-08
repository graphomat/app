import pytest
from fastapi import status
from app.schemas.graph import GraphCreate, GraphUpdate

def test_create_graph(authorized_client):
    """Test creating a new graph."""
    graph_data = {
        "title": "Test Graph",
        "description": "Test Description",
        "status": "draft",
        "config": {"test": "config"}
    }
    response = authorized_client.post("/api/v1/graphs/", json=graph_data)
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert data["title"] == graph_data["title"]
    assert data["description"] == graph_data["description"]
    assert data["status"] == graph_data["status"]
    assert data["config"] == graph_data["config"]
    assert "id" in data
    assert "user_id" in data

def test_create_graph_invalid_status(authorized_client):
    """Test creating a graph with invalid status."""
    graph_data = {
        "title": "Test Graph",
        "description": "Test Description",
        "status": "invalid_status",
        "config": {"test": "config"}
    }
    response = authorized_client.post("/api/v1/graphs/", json=graph_data)
    assert response.status_code == status.HTTP_422_UNPROCESSABLE_ENTITY

def test_get_graph(authorized_client, test_graph):
    """Test retrieving a specific graph."""
    response = authorized_client.get(f"/api/v1/graphs/{test_graph.id}")
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert data["id"] == test_graph.id
    assert data["title"] == test_graph.title
    assert data["description"] == test_graph.description
    assert data["status"] == test_graph.status
    assert data["config"] == test_graph.config
    assert data["user_id"] == test_graph.user_id

def test_get_graph_not_found(authorized_client):
    """Test retrieving a non-existent graph."""
    response = authorized_client.get("/api/v1/graphs/999")
    assert response.status_code == status.HTTP_404_NOT_FOUND

def test_list_graphs(authorized_client, test_graph):
    """Test listing all graphs for the current user."""
    response = authorized_client.get("/api/v1/graphs/")
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert isinstance(data, list)
    assert len(data) > 0
    assert data[0]["id"] == test_graph.id
    assert data[0]["title"] == test_graph.title

def test_list_graphs_with_status(authorized_client, test_graph):
    """Test listing graphs filtered by status."""
    response = authorized_client.get("/api/v1/graphs/?status=draft")
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert isinstance(data, list)
    assert len(data) > 0
    assert all(graph["status"] == "draft" for graph in data)

def test_update_graph(authorized_client, test_graph):
    """Test updating a graph."""
    update_data = {
        "title": "Updated Graph",
        "description": "Updated Description",
        "status": "active",
        "config": {"updated": "config"}
    }
    response = authorized_client.put(
        f"/api/v1/graphs/{test_graph.id}",
        json=update_data
    )
    assert response.status_code == status.HTTP_200_OK
    data = response.json()
    assert data["id"] == test_graph.id
    assert data["title"] == update_data["title"]
    assert data["description"] == update_data["description"]
    assert data["status"] == update_data["status"]
    assert data["config"] == update_data["config"]

def test_update_graph_not_found(authorized_client):
    """Test updating a non-existent graph."""
    update_data = {
        "title": "Updated Graph",
        "description": "Updated Description",
        "status": "active",
        "config": {"updated": "config"}
    }
    response = authorized_client.put("/api/v1/graphs/999", json=update_data)
    assert response.status_code == status.HTTP_404_NOT_FOUND

def test_delete_graph(authorized_client, test_graph):
    """Test deleting a graph."""
    response = authorized_client.delete(f"/api/v1/graphs/{test_graph.id}")
    assert response.status_code == status.HTTP_200_OK
    
    # Verify the graph is deleted
    response = authorized_client.get(f"/api/v1/graphs/{test_graph.id}")
    assert response.status_code == status.HTTP_404_NOT_FOUND

def test_delete_graph_not_found(authorized_client):
    """Test deleting a non-existent graph."""
    response = authorized_client.delete("/api/v1/graphs/999")
    assert response.status_code == status.HTTP_404_NOT_FOUND

def test_unauthorized_access(client, test_graph):
    """Test accessing endpoints without authentication."""
    endpoints = [
        ("GET", f"/api/v1/graphs/{test_graph.id}"),
        ("GET", "/api/v1/graphs/"),
        ("POST", "/api/v1/graphs/"),
        ("PUT", f"/api/v1/graphs/{test_graph.id}"),
        ("DELETE", f"/api/v1/graphs/{test_graph.id}")
    ]
    
    for method, endpoint in endpoints:
        response = client.request(method, endpoint)
        assert response.status_code == status.HTTP_401_UNAUTHORIZED
