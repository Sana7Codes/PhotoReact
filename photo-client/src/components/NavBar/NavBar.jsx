import React from 'react';
import { Link } from 'react-router-dom';
import './NavBar.css';

const NavBar = ({ authUser, onLogout }) => {
  return (
    <nav className="navbar">
      <div className="navbar-brand">
        <Link to="/" className="navbar-title">React Gallery</Link>
      </div>
      <div className="navbar-links">
        {authUser ? (
          <>
            
            <button className="logout-button" onClick={onLogout}>Logout</button>
          </>
        ) : (
          <>
            <Link to="/login" className="nav-link">Login</Link>
            <Link to="/register" className="nav-link">Register</Link>
          </>
        )}
      </div>
    </nav>
  );
};

export default NavBar;
