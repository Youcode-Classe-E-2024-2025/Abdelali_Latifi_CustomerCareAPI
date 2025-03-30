export const getUser = async () => {
    try {
      const response = await fetch("http://127.0.0.1:8000/api/user", {
        headers: {
          "Authorization": `Bearer ${localStorage.getItem("token")}`,
        },
      });
      if (!response.ok) {
        throw new Error("Échec de la récupération de l'utilisateur");
      }
      return await response.json();
    } catch (error) {
      console.error("Erreur de récupération de l'utilisateur:", error);
      throw error;
    }
  };
  
  export const login = async (credentials) => {
    try {
      const response = await fetch("http://localhost:8000/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
      });
  
      if (!response.ok) {
        throw new Error("Échec de la connexion");
      }
  
      return await response.json();
    } catch (error) {
      console.error("Erreur lors de la requête login:", error);
      throw error;
    }
  };
  
  export const register = async (userData) => {
    try {
      const response = await fetch("http://localhost:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(userData),
      });
  
      if (!response.ok) {
        throw new Error("Échec de l'inscription");
      }
  
      return await response.json();
    } catch (error) {
      console.error("Erreur lors de la requête d'inscription:", error);
      throw error;
    }
  };
  
  export const logout = async () => {
    try {
      const response = await fetch("http://localhost:8000/api/logout", {
        method: "POST",
        headers: {
          "Authorization": `Bearer ${localStorage.getItem("token")}`,
        },
      });
  
      if (!response.ok) {
        throw new Error("Échec de la déconnexion");
      }
  
      return await response.json();
    } catch (error) {
      console.error("Erreur lors de la déconnexion:", error);
      throw error;
    }
  };
  