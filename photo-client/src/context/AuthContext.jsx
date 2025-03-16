import React, { createContext, useContext, useState } from 'react';

const AuthContext = createContext();

export function AuthProvider({ children }) {
  const [authUser, setAuthUser] = useState(null);
  const [token, setToken] = useState(localStorage.getItem('token') || null);

  const login = (userData, authToken) => {
    localStorage.setItem('token', authToken);
    setAuthUser(userData);
    setToken(authToken);
  };

  const logout = () => {
    localStorage.removeItem('token');
    setAuthUser(null);
    setToken(null);
  };

  return (
    <AuthContext.Provider value={{ authUser, token, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  return useContext(AuthContext);
}