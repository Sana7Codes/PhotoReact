import React from 'react';
import './ImageCard.css';

const ImageCard = ({ imageData, onClick, onDelete }) => {
  return (
    <div className="image-card" onClick={onClick}>
      <img
        src={imageData.url}
        alt={imageData.title || `Image ${imageData.id}`}
        className="image-card-img"
      />
      <div className="image-hover-overlay">
        <div className="overlay-content">
          <p className="image-title">{imageData.title}</p>
        
            
        </div>
      </div>
    </div>
  );
};

export default ImageCard;
