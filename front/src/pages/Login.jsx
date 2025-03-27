import { useState, useContext } from "react";
import { AuthContext } from "../context/AuthContext";
import { useNavigate } from "react-router-dom";

const Login = () => {
  const [credentials, setCredentials] = useState({ email: "", password: "" });
  const { handleLogin } = useContext(AuthContext);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await handleLogin(credentials);
      navigate("/dashboard");
    } catch (error) {
      alert("Échec de la connexion");
    }
  };

  return (
    <div>
      <h2>Connexion</h2>
      <form onSubmit={handleSubmit}>
        <input type="email" placeholder="Email" onChange={(e) => setCredentials({ ...credentials, email: e.target.value })} required />
        <input type="password" placeholder="Mot de passe" onChange={(e) => setCredentials({ ...credentials, password: e.target.value })} required />
        <button type="submit">Se connecter</button>
      </form>
    </div>
  );
};

export default Login;
