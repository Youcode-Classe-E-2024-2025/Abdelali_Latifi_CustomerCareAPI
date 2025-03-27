import { useState, useContext } from "react";
import { AuthContext } from "../context/AuthContext";
import { useNavigate } from "react-router-dom";

const Register = () => {
  const [userData, setUserData] = useState({ name: "", email: "", password: "", role: "client" });
  const { handleRegister } = useContext(AuthContext);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await handleRegister(userData);
      navigate("/dashboard");
    } catch (error) {
      alert("Échec de l'inscription");
    }
  };

  return (
    <div>
      <h2>Inscription</h2>
      <form onSubmit={handleSubmit}>
        <input type="text" placeholder="Nom" onChange={(e) => setUserData({ ...userData, name: e.target.value })} required />
        <input type="email" placeholder="Email" onChange={(e) => setUserData({ ...userData, email: e.target.value })} required />
        <input type="password" placeholder="Mot de passe" onChange={(e) => setUserData({ ...userData, password: e.target.value })} required />
        <select onChange={(e) => setUserData({ ...userData, role: e.target.value })}>
          <option value="client">Client</option>
          <option value="agent">Agent</option>
          <option value="admin">Admin</option>
        </select>
        <button type="submit">S'inscrire</button>
      </form>
    </div>
  );
};

export default Register;
