import React, { useState } from 'react';
import Button from '../Button/Button';
import './UploadForm.css';

const UploadForm = ({ onSave, onCancel }) => {
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewUrl, setPreviewUrl] = useState('');
  const [title, setTitle] = useState('');
  const [error, setError] = useState('');

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setSelectedFile(file);
      const url = URL.createObjectURL(file);
      setPreviewUrl(url);
    }
  };

  const handleSave = () => {
    // Validate file and title
    if (!selectedFile) {
      setError('Please select a file.');
      return;
    }
    if (!title.trim()) {
      setError('Please enter a title.');
      return;
    }

    // Convert file to base64
    const reader = new FileReader();
    reader.onloadend = () => {
      onSave({
        base64: reader.result,
        title: title.trim()
      });
    };
    reader.readAsDataURL(selectedFile);
  };

  return (
    <div className="upload-form-container">
      <div className="upload-form">
        <h2 className="upload-form-title">Upload Image</h2>
        {error && <div className="upload-error">{error}</div>}

        <input
          type="file"
          onChange={handleFileChange}
          className="upload-input"
        />
        {previewUrl && (
          <img
            src={previewUrl}
            alt="Preview"
            className="upload-preview"
          />
        )}

        <label htmlFor="title" className="upload-label">
          Title
        </label>
        <input
          id="title"
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          className="upload-text-input"
        />

        <div className="upload-button-group">
          <Button text="Save" onClick={handleSave} />
          <Button text="Cancel" onClick={onCancel} className="cancel-btn" />
        </div>
      </div>
    </div>
  );
};

export default UploadForm;
