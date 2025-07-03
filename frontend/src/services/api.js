import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://localhost:8000',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true, // Important for Laravel Sanctum cookie authentication
});

export const authService = {
  csrf: async () => {
    return api.get('/sanctum/csrf-cookie');
  },
  
  login: async (credentials) => {
    await authService.csrf();
    return api.post('/login', credentials);
  },
  
  logout: async () => {
    return api.post('/logout');
  },
  
  getUser: async () => {
    return api.get('/user');
  },
};

export const todoService = {
  getAll: async (params = {}) => {
    return api.get('/api/todos', { params });
  },
  
  get: async (id) => {
    return api.get(`/api/todos/${id}`);
  },
  
  create: async (data) => {
    return api.post('/api/todos', data);
  },
  
  update: async (id, data) => {
    return api.put(`/api/todos/${id}`, data);
  },
  
  delete: async (id) => {
    return api.delete(`/api/todos/${id}`);
  },
};

export default api;
