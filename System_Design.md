# System Design: Secure Login System

## 1. System Flowchart
This flowchart illustrates the complete user journey and logic flow throughout the authentication lifecycle.

```mermaid
flowchart TD
    A[User visits index.php] --> B{Has Account?}
    B -- No --> C[Navigates to register.php]
    B -- Yes --> D[Enters Email & Password]
    
    C --> E[Fills Registration Form]
    E --> F{Client Validation Passes?}
    F -- No --> C
    F -- Yes --> G[Submit to Server]
    G --> H{Server Validation & DB Check Passes?}
    H -- No --> C
    H -- Yes --> I[Hash Password & Insert to DB]
    I --> J[Success Message & Redirect to index.php]
    J --> D
    
    D --> K[Submit to Server]
    K --> L{Credentials Match DB?}
    L -- No --> M[Display Error Message]
    M --> D
    L -- Yes --> N[Regenerate Session ID & Set $_SESSION variables]
    N --> O[Redirect to dashboard.php]
    
    O --> P{Session Valid?}
    P -- No --> Q[Redirect to index.php]
    P -- Yes --> R[Fetch User Profile from DB & Display]
    
    R --> S[User clicks Logout]
    S --> T[Destroy Session]
    T --> Q
```

## 2. Entity Relationship Diagram (ERD)
The database for the secure login system requires robust and normalized data structures for users and password reset logic.

```mermaid
erDiagram
    USERS {
        int id PK "AUTO_INCREMENT"
        varchar(50) username "NOT NULL, UNIQUE"
        varchar(100) email "NOT NULL, UNIQUE"
        varchar(255) password_hash "NOT NULL"
        timestamp created_at "DEFAULT CURRENT_TIMESTAMP"
    }
    
    PASSWORD_RESETS {
        int id PK "AUTO_INCREMENT"
        varchar(100) email "NOT NULL, FK to users.email"
        varchar(255) token "NOT NULL"
        datetime expires_at "NOT NULL"
    }

    USERS ||--o{ PASSWORD_RESETS : "can request"
```

## 3. UI Mockups / Wireframes

While actual high-fidelity designs are implemented in `style.css`, the fundamental wireframes of the application focus on centering the authentication block (`auth-container`) on the screen with a clean, modern aesthetic.

### Registration Page Wireframe
- Main Centered Card Container
- Title: "Create an Account"
- Text Input: Username
- Email Input: Email Address
- Password Input: Password
- Password Input: Confirm Password
- Primary Button: "Register" (Solid color)
- Footer Link: "Already have an account? Login here"

### Login Page Wireframe
- Main Centered Card Container
- Title: "Welcome Back"
- Space reserved for Success/Error Alert messages (e.g., "Registration successful!")
- Email Input: Email Address
- Password Input: Password
- Primary Button: "Login" (Solid color)
- Footer Links: "Forgot Password?" | "Create an Account"

### Dashboard (Profile) Wireframe
- Main Container with Top Header
- Header Left: "Dashboard"
- Header Right: "Logout" (Secondary Button, outline styling)
- Welcome Message: "Welcome, [Username]!" (Followed by dynamic success alerts if logging in)
- Profile Information Card (Slightly darker background):
  - Username: [Value]
  - Email Address: [Value]
  - Member Since: [Date]
