// File: src/types/graph.ts
export interface Graph {
    id: string;
    name: string;
    nodes: Node[];
    edges: Edge[];
    status: 'draft' | 'ready' | 'deployed' | 'error';
    createdAt: string;
    updatedAt: string;
}

interface Node {
    id: string;
    type: string;
    position: { x: number; y: number };
    data: Record<string, any>;
}

interface Edge {
    id: string;
    source: string;
    target: string;
    type: string;
}
