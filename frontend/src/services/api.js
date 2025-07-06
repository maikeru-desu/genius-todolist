import axios from 'axios';

/**
 * Get cookie by name
 * @param {string} name - Cookie name
 * @returns {string|null} - Cookie value or null
 */
function getCookie(name) {
  const match = document.cookie.match(new RegExp('(^|;\\s*)' + name + '=([^;]*)'));
  return match ? match[2] : null;
}

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://localhost:8000',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true, // Important for Laravel Sanctum cookie authentication
});

// Add request interceptor to include CSRF token
api.interceptors.request.use(request => {
  // Get the XSRF-TOKEN from cookie
  const token = getCookie('XSRF-TOKEN');
  if (token) {
    // Add the token to X-XSRF-TOKEN header
    request.headers['X-XSRF-TOKEN'] = decodeURIComponent(token);
  }
  return request;
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
    return api.get('/api/user');
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
  
  getAiInsight: async () => {
    return api.get('/api/ai/get-insight');
  },
};

export default api;
