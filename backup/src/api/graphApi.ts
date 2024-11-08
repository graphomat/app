import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL;

export const graphApi = {
    createGraph: async (graph: Partial<Graph>) => {
        const response = await axios.post(`${API_URL}/graphs`, graph);
        return response.data;
    },

    deployGraph: async (graphId: string) => {
        const response = await axios.post(`${API_URL}/graphs/${graphId}/deploy`);
        return response.data;
    },

    getGraphs: async () => {
        const response = await axios.get(`${API_URL}/graphs`);
        return response.data;
    },

    getGraphStatus: async (graphId: string) => {
        const response = await axios.get(`${API_URL}/graphs/${graphId}/status`);
        return response.data;
    }
};

