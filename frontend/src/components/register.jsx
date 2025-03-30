import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

const Register = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    role: "client",
  });
  const [errorMessage, setErrorMessage] = useState("");

  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await api.post("/register", formData);
      console.log("Inscription réussie :", response.data);

      if (response.data.success) {
        console.log("Redirection vers la page de login...");
        navigate("/login"); 
      } else {
        console.error("Erreur dans la réponse de l'API :", response.data);
        setErrorMessage("Erreur dans la réponse de l'API.");
      }
    } catch (error) {
      if (error.response) {
   
        console.error("Erreur lors de l'inscription :", error.response.data);
        console.error("Status code:", error.response.status);
        setErrorMessage("Erreur lors de l'inscription : " + error.response.data.message);
      } else if (error.request) {
        console.error("Erreur lors de l'inscription : No response received");
        console.error("Request data:", error.request);
        setErrorMessage("Erreur lors de l'inscription : No response received. Please check your network connection.");
      } else {
        console.error("Erreur lors de l'inscription :", error.message);
        setErrorMessage("Erreur lors de l'inscription : " + error.message);
      }
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      {errorMessage && <p style={{ color: "red" }}>{errorMessage}</p>}
      <input
        type="text"
        name="name"
        placeholder="Nom"
        onChange={handleChange}
      />
      <input
        type="email"
        name="email"
        placeholder="Email"
        onChange={handleChange}
      />
      <input
        type="password"
        name="password"
        placeholder="Mot de passe"
        onChange={handleChange}
      />
      <button type="submit">S'inscrire</button>
    </form>
  );
};

export default Register;
