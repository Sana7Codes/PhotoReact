import React, { useState, useEffect } from 'react';
import ImageCard from '../../components/ImageCard/ImageCard';
import UploadForm from '../../components/UploadForm/UploadForm';
import './style.css';

const GalleryPage = ({ authUser }) => {
  const [images, setImages] = useState([]);
  const [showUploadForm, setShowUploadForm] = useState(false);
  const [selectedImage, setSelectedImage] = useState(null);
  const [showReason, setShowReason] = useState(false); // toggles reason input
  const [reasonText, setReasonText] = useState('');    // user’s reason for deletion

  // Load images from localStorage on mount
  useEffect(() => {
    const stored = JSON.parse(localStorage.getItem('images')) || [];
    setImages(stored);
  }, []);

  // Persist images to localStorage whenever they change
  useEffect(() => {
    localStorage.setItem('images', JSON.stringify(images));
  }, [images]);

  // Handle saving a new image
  const handleUploadSave = (newImage) => {
    const imageObject = {
      id: Date.now(),
      url: newImage.base64,
      title: newImage.title
    };
    setImages([...images, imageObject]);
    setShowUploadForm(false);
  };

  // User clicks thumbnail → open the modal
  const handleImageClick = (img) => {
    setSelectedImage(img);
    setShowReason(false); // Hide reason area by default
    setReasonText('');    // Clear any old reason
  };

  // Close the modal
  const handleCloseModal = () => {
    setSelectedImage(null);
    setShowReason(false);
    setReasonText('');
  };

  // When user clicks "Delete" in the modal
  const handleDeleteClick = () => {
    setShowReason(true); // Show the reason text area & confirm/cancel
  };

  // Confirm deletion after reason
  const handleConfirmDelete = () => {
    if (!reasonText.trim()) {
      alert('Please provide a reason for deletion.');
      return;
    }
    // Remove the image
    if (selectedImage) {
      setImages((prev) => prev.filter((img) => img.id !== selectedImage.id));
      console.log(`Deleted image ${selectedImage.id} for reason:`, reasonText);
    }
    // Close the modal
    handleCloseModal();
  };

  return (
    <div className="gallery-page">
      <h2>Welcome, {authUser?.username || 'Guest'}!</h2>

      <button
        className="gallery-upload-btn"
        onClick={() => setShowUploadForm(true)}
      >
        Upload Image
      </button>

      {showUploadForm && (
        <UploadForm
          onSave={handleUploadSave}
          onCancel={() => setShowUploadForm(false)}
        />
      )}

      {/* Thumbnails grid */}
      <div className="gallery-grid">
        {images.map((img) => (
          <ImageCard
            key={img.id}
            imageData={img}
            onClick={() => handleImageClick(img)}
          />
        ))}
      </div>

      {/* Full-size modal */}
      {selectedImage && (
        <div className="modal-overlay" onClick={handleCloseModal}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            {/* Display the image at real size */}
            <img
              src={selectedImage.url}
              alt={selectedImage.title}
              className="fullsize-image"
            />
            <h3>{selectedImage.title}</h3>

            {/* If showReason is false, show the "Delete" button */}
            {!showReason && (
              <button className="delete-button-modal" onClick={handleDeleteClick}>
                Delete
              </button>
            )}

            {showReason && (
              <div className="delete-reason-section">
                <textarea
                  rows="3"
                  placeholder="Reason..."
                  value={reasonText}
                  onChange={(e) => setReasonText(e.target.value)}
                />
                <div className="reason-buttons">
                  <button onClick={handleConfirmDelete}>Confirm</button>
                  <button onClick={handleCloseModal}>Cancel</button>
                </div>
              </div>
            )}

            <button className="close-button" onClick={handleCloseModal}>
              X
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default GalleryPage;



