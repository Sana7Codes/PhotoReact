import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router } from 'react-router-dom';
import RoutesFile from './routes/Routes';
import Navbar from './components/NavBar/NavBar';

const App = () => {
  const [authUser, setAuthUser] = useState(null);

  // Rehydrate auth state from localStorage
  useEffect(() => {
    const savedUser = localStorage.getItem('authUser');
    if (savedUser && savedUser !== 'undefined') {
      setAuthUser(JSON.parse(savedUser));
    }
  }, []);

  // Callback to handle login, store user in localStorage
  const handleLogin = (user) => {
    setAuthUser(user);
    localStorage.setItem('authUser', JSON.stringify(user));
  };

  // Callback to handle logout
  const handleLogout = () => {
    setAuthUser(null);
    localStorage.removeItem('authUser');
  };

  return (
    <Router>
      <Navbar authUser={authUser} onLogout={handleLogout} />
      <div className="app-content">
        <RoutesFile authUser={authUser} onLogin={handleLogin} />
      </div>
    </Router>
  );
};

export default App;
