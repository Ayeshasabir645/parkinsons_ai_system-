# Parkinson's AI System

An AI-based web application for Parkinson's disease prediction and analysis, built with a HTML/CSS/JS frontend connected to a PHP backend with session management.

## 🧠 Overview

This project provides an interactive platform where users can log in, run predictions related to Parkinson's disease indicators, understand the reasoning behind predictions (explainability), find nearby hospitals, and view training/model information through a clean dashboard interface.

## 📂 Project Structure

```
parkinsons_ai_system/
│
├── frontend/
│   ├── login.html            # User authentication page
│   ├── dashboard.html         # Main dashboard after login
│   ├── prediction.html        # Parkinson's prediction interface
│   ├── explainability.html    # Model explainability / results interpretation
│   ├── hospitals.html         # Nearby hospitals / resources page
│   ├── training.html          # Model training information page
│   ├── script.js               # Core JavaScript functionality
│   └── style.css               # Styling for all pages
│
└── backend/
    ├── login.php              # Handles login authentication
    ├── register.php           # Handles new user registration
    ├── logout.php             # Session logout handler
    ├── dashboard.php          # Dashboard data / server-side logic
    ├── edit_patient.php       # Edit patient records
    ├── delete_patient.php     # Delete patient records
    ├── db.php                 # Database connection config
    └── parkinsons_db.sql      # Database schema
```

## ✨ Features

- 🔐 **Login & Registration** — Secure user authentication with PHP session management
- 📊 **Dashboard** — Centralized view of user activity and predictions
- 🧪 **Prediction Module** — AI-driven Parkinson's disease prediction
- 🔍 **Explainability** — Insights into how predictions are made
- 🏥 **Hospitals Locator** — Find nearby healthcare facilities
- 📈 **Training Insights** — View model training details and performance
- 🗂️ **Patient Management** — Add, edit, and delete patient records via the backend
- 🗄️ **MySQL Database** — Structured storage using `parkinsons_db.sql`

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Session Handling:** PHP Sessions

## 🚀 Getting Started

1. Clone the repository
   ```bash
   git clone https://github.com/username/parkinsons_ai_system.git
   ```
2. Set up a local server environment (e.g., XAMPP/WAMP) to run the PHP backend
3. Place the project folder inside your server's `htdocs` (or equivalent) directory
4. Start the server and open `login.html` in your browser

## 👩‍💻 Author

**Ayesha Sabir**
BSIT, NUML Islamabad

## 📄 License

This project is developed for academic purposes as part of a semester project.
