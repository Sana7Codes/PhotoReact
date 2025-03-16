import React, { useState } from 'react';
import './DeleteForm.css';

const DeleteForm = ({ imageId, onConfirm, onCancel }) => {
  const [reason, setReason] = useState('');

  const handleConfirm = () => {
    if (!reason.trim()) {
      alert('Please provide a reason for deletion.');
      return;
    }
    onConfirm(imageId, reason.trim());
  };

  return (
    <div className="delete-form-overlay" onClick={onCancel}>
      <div className="delete-form-content" onClick={(e) => e.stopPropagation()}>
        <h3>Confirm Deletion</h3>
        <p>Please enter a reason for deleting this image:</p>
        <textarea
          value={reason}
          onChange={(e) => setReason(e.target.value)}
          rows="3"
          placeholder="Reason..."
        />
        <div className="delete-form-buttons">
          <button onClick={handleConfirm}>Delete</button>
          <button onClick={onCancel}>Cancel</button>
        </div>
      </div>
    </div>
  );
};

export default DeleteForm;

