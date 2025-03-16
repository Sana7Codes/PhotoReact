import React from 'react';
import './Button.css';

const Button = ({ text, onClick, className = "", type = "button" }) => {
  return (
    <button type={type} className={`lux-button ${className}`} onClick={onClick}>
      {text}
    </button>
  );
};

export default Button;
