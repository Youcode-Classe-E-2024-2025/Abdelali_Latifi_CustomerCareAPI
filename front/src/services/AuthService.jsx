import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/auth';

export const getUser = async () => {
  const response = await axios.get(`${API_URL}/user`, {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
  });
  return response;
};

export const login = async (credentials) => {
  const response = await axios.post(`${API_URL}/login`, credentials);
  return response;
};

export const register = async (userData) => {
  const response = await axios.post(`${API_URL}/register`, userData);
  return response;
};

export const logout = async () => {
  await axios.post(`${API_URL}/logout`, {}, {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
  });
};
