import React from 'react';
import { useNavigate } from 'react-router-dom';
import RegisterForm from '../../components/RegisterForm/RegisterForm';
import './style.css';

const RegisterPage = () => {
  const navigate = useNavigate();

  const handleRegisterSubmit = (formData, setError) => {
    const { username, email, password } = formData;
    const users = JSON.parse(localStorage.getItem('users')) || [];

    // Check if user already exists
    if (users.some((u) => u.email === email)) {
      setError('A user with this email already exists.');
      return;
    }

    // Save new user
    users.push({ username, email, password });
    localStorage.setItem('users', JSON.stringify(users));

    // Redirect to login
    navigate('/login');
  };

  return (
    <div className="register-page">
      <RegisterForm onSubmit={handleRegisterSubmit} />
    </div>
  );
};

export default RegisterPage;
