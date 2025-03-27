import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api"; // Assure-toi que c'est bien ton backend

axios.defaults.withCredentials = true; // Permet l’authentification Sanctum

export const register = async (userData) => {
  return axios.post(`${API_URL}/register`, userData);
};

export const login = async (credentials) => {
  return axios.post(`${API_URL}/login`, credentials);
};

export const getUser = async () => {
  return axios.get(`${API_URL}/user`, {
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
  });
};

export const logout = async () => {
  return axios.post(`${API_URL}/logout`, null, {
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
  });
};
