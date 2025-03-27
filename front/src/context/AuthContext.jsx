import { createContext, useState, useEffect } from "react";
import { getUser, login, logout, register } from "../services/authService";

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const response = await getUser();
        setUser(response.data);
      } catch (error) {
        setUser(null);
      }
      setLoading(false);
    };
    fetchUser();
  }, []);

  const handleLogin = async (credentials) => {
    const response = await login(credentials);
    localStorage.setItem("token", response.data.token);
    setUser(response.data.user);
  };

  const handleRegister = async (userData) => {
    const response = await register(userData);
    localStorage.setItem("token", response.data.token);
    setUser(response.data.user);
  };

  const handleLogout = async () => {
    await logout();
    localStorage.removeItem("token");
    setUser(null);
  };

  return (
    <AuthContext.Provider value={{ user, loading, handleLogin, handleRegister, handleLogout }}>
      {children}
    </AuthContext.Provider>
  );
};
