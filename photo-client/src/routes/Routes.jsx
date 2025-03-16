import React, { lazy, Suspense } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';

// Lazy-load pages for performance
const LoginPage = lazy(() => import('../pages/LoginPage'));
const RegisterPage = lazy(() => import('../pages/RegisterPage'));
const GalleryPage = lazy(() => import('../pages/GalleryPage'));
const ProtectedRoute = lazy(() => import("../components/ProtectedRoute"));


const RoutesFile = ({ authUser, onLogin }) => {
  return (
    <Suspense fallback={<div>Loading...</div>}>
      <Routes>
        <Route path="/login" element={<LoginPage onLogin={onLogin} />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route
          path="/gallery"
          element={
            <ProtectedRoute authUser={authUser}>
              <GalleryPage authUser={authUser} />
            </ProtectedRoute>
          }
        />
        {/* Default/fallback route */}
        <Route path="*" element={<Navigate to={authUser ? "/gallery" : "/login"} />} />
      </Routes>
    </Suspense>
  );
};

export default RoutesFile;
