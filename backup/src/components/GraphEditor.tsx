
import React from 'react';
import ReactFlow, {
    Controls,
    Background,
    Connection,
    Edge,
    Node
} from 'react-flow-renderer';

interface GraphEditorProps {
    nodes: Node[];
    edges: Edge[];
    onNodesChange: (nodes: Node[]) => void;
    onEdgesChange: (edges: Edge[]) => void;
    onConnect: (connection: Connection) => void;
}

export const GraphEditor: React.FC<GraphEditorProps> = ({
                                                            nodes,
                                                            edges,
                                                            onNodesChange,
                                                            onEdgesChange,
                                                            onConnect
                                                        }) => {
    return (
        <div style={{ height: '80vh' }}>
            <ReactFlow
                nodes={nodes}
                edges={edges}
                onNodesChange={onNodesChange}
                onEdgesChange={onEdgesChange}
                onConnect={onConnect}
            >
                <Controls />
                <Background />
            </ReactFlow>
        </div>
    );
};

