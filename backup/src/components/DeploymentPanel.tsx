import React from 'react';
import { Button, Alert } from '@/components/ui';

interface DeploymentPanelProps {
    graphId: string;
    status: string;
    onDeploy: () => void;
}

export const DeploymentPanel: React.FC<DeploymentPanelProps> = ({
                                                                    graphId,
                                                                    status,
                                                                    onDeploy
                                                                }) => {
    return (
        <div className="p-4 border rounded shadow">
            <h3 className="text-lg font-bold mb-4">Deployment Status</h3>
            <Alert
                variant={status === 'deployed' ? 'success' : 'info'}
            >
                Current Status: {status}
            </Alert>
            <Button
                onClick={onDeploy}
                disabled={status === 'deploying'}
                className="mt-4"
            >
                {status === 'deploying' ? 'Deploying...' : 'Deploy Graph'}
            </Button>
        </div>
    );
};