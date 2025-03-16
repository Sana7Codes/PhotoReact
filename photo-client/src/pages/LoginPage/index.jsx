import React from 'react';
import { useNavigate } from 'react-router-dom';
import LoginForm from '../../components/LoginForm/LoginForm';
import './style.css';

const LoginPage = ({ onLogin }) => {
  const navigate = useNavigate();

  // Called when LoginForm is submitted
  const handleLoginSubmit = (formData, setError) => {
    const { email, password } = formData;
    const users = JSON.parse(localStorage.getItem('users')) || [];

    const foundUser = users.find(
      (u) => u.email === email && u.password === password
    );

    if (!foundUser) {
      setError('Invalid credentials.');
      return;
    }

    // Successful login
    onLogin(foundUser);
    navigate('/gallery');
  };

  return (
    <div className="login-page">
      <LoginForm onSubmit={handleLoginSubmit} />
    </div>
  );
};

export default LoginPage;
