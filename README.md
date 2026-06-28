# ClubPilot 🎓

A web platform for managing university student clubs, built as a backend 
end-of-year project using **Laravel 13**, **MySQL**, and **Blade + Tailwind CSS**.

---

## 📌 Overview

ClubPilot is a full-featured club management system designed for university 
environments. It allows students to create and join clubs, organize events, 
manage tasks, track budgets, and communicate through internal notifications — 
all within a role-based access control system.

---

## ✨ Features

- **Club Management** : Create, edit, and browse university clubs
- **Membership System** : Submit join requests, approve or refuse memberships
- **Role-Based Access Control** : Three roles per club — President, Admin, and Member — each with specific permissions
- **Event Management** : Create and manage club events with full CRUD support
- **QR Code Attendance** : Generate QR codes for events; members scan to confirm their presence
- **PDF Export** : Export attendance lists as downloadable PDF files
- **Task Management** : Create, assign, prioritize, and track tasks with comments
- **Budget Tracking** : Record and categorize income/expense transactions with real-time balance
- **Internal Notifications** : Send messages to all active club members with read tracking
- **Dashboard** : Personal dashboard and per-club dashboard with key statistics
- **Profile Management** : Update personal information and password

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 13 (PHP 8.3) |
| Database | MySQL |
| ORM | Eloquent |
| Frontend | Blade + Tailwind CSS |
| Build Tool | Vite |
| QR Code Generation | endroid/qr-code |
| PDF Generation | barryvdh/laravel-dompdf |

---

## ⚙️ Installation

### Prerequisites
- PHP >= 8.3
- Composer
- Node.js & npm
- MySQL

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/Mohamed-Souabni/ClubPilot.git
cd ClubPilot
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install JS dependencies**
```bash
npm install
```

**4. Set up environment file**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configure the database**

Open `.env` and set your database credentials :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clubpilot
DB_USERNAME=root
DB_PASSWORD=
```

**6. Run migrations and seeders**
```bash
php artisan migrate --seed
```

**7. Build frontend assets**
```bash
npm run build
```

**8. Start the development server**
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

---

## 🔐 Demo Accounts

After running the seeders, the following test accounts are available :

| Role | Email | Password |
|---|---|---|
| President | president@clubpilot.test | password |
| Admin | admin@clubpilot.test | password |
| Member | membre@clubpilot.test | password |

---

## 📁 Project Structure

app/

├── Http/

│   └── Controllers/     # Application controllers

├── Models/              # Eloquent models

resources/

├── views/               # Blade templates

routes/

└── web.php              # Application routes

database/

├── migrations/          # Database structure

└── seeders/             # Demo data



## 👨‍💻 Author

**Mohamed Souabni**
End-of-year project — Backend Development Module
FSTG Cadi Ayyad University , Marrakech
