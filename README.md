````markdown
# 🖼️ PhotoReact 

An image gallery application built with React and modern web technologies.

## 📦 Component Architecture

### Component Hierarchy

```mermaid
graph TD
  A[App] --> B[AuthProvider]
  A --> C[Router]
  C --> F[RegisterPage]
  C --> E[LoginPage]
  C --> G[ProtectedRoute]
  G --> H[GalleryPage]
 
  
```
````

### Core Components

| Component       | Type           | Props               | State         | Description                         |
| --------------- | -------------- | ------------------- | ------------- | ----------------------------------- |
| `App`           | Root           | -                   | Auth Context  | Application root with router config |
| `AuthProvider`  | Context        | -                   | User, Token   | Authentication state management     |
| `ProtectedRoute | HOC            | children            | -             | Route protection wrapper            |
| `GalleryPage`   | Container      | -                   | images,quey   | Main gallery interface              |
| `ImageCard`     | Presentational | imageData, onDelete | -             | Image display card                  |
| `UploadForm`    | Composite      | onSave, onClose     | file, preview | File upload modal                   |

## 🔄 Data Flow

### Authentication Sequence

```mermaid
sequenceDiagram
  participant U as User
  participant L as LoginPage
  participant A as AuthProvider
  participant P as ProtectedRoute

  U->>L: Submit credentials
  L->>A: login()
  A->>LocalStorage: Store token
  A->>P: Update auth state
  P->>GalleryPage: Render content
```

### Image Management Flow

```mermaid
flowchart TD
  A[GalleryPage] -->|fetch| B(API)
  B -->|response| A
  A --> C[ImageGrid]
  C --> D[ImageCard]
  D -->|save| A
  A -->|update| B
```
