# Laravel + Nuxt Industrial Performance Dashboard

This personal project is a full-stack industrial performance dashboard built with **Laravel**, **Nuxt**, and **C# microservices**. It is designed to explore a modern, enterprise-grade architecture integrating multiple technologies.  

The goal is to **demonstrate my ability to design and implement complex, distributed applications from scratch**, learning everything independently without prior experience in these specific frameworks.

---

## Key Technologies, Frameworks, and Concepts

During this project, I am learning and applying:

- **Laravel** – PHP back-end framework for API development, database management, and authentication.  
- **Laravel Sanctum** – Provides lightweight API authentication for secure communication between frontend and backend.  
- **Nuxt** – Front-end framework for building interactive, component-based dashboards (Vue.js based, **not Angular**).  
- **Tailwind CSS / daisyUI** – Tailwind CSS for utility-first styling, with daisyUI providing ready-to-use UI components.
- **C# Microservices** – Lightweight services handling background tasks and real-time data streaming.  
- **PostgreSQL** – Relational database for structured industrial performance data.  
- **RESTful APIs** – Standard communication pattern between services and frontend.  

---

## Features

- User authentication and session management using **Laravel Sanctum**  
- Interactive, responsive dashboard built with **Nuxt** and **daisyUI**  
- Real-time data visualization from C# microservices  
- Fully decoupled architecture for scalable, maintainable applications  

---

## Getting Started

### 1. Backend Setup (Laravel API)

```bash
cd api/
composer install
php artisan migrate
php artisan serve
```
The API will run at: http://localhost:8000

### 2. Frontend Setup (Nuxt Client)
```bash
cd client/
npm install
npm run dev
```
The client will run at: http://localhost:3000

### 3. Run the application
Once both backend and frontend are running, open your browser and visit: http://localhost:3000

---

## Authentication Flow

1. Users register or log in via the Nuxt frontend.

2. The Laravel Sanctum API issues secure cookies for authenticated sessions.

3. The frontend communicates with the API using RESTful requests for protected resources.

---

## Notes

- This project is a learning exercise to gain hands-on experience with modern full-stack architecture.
- Focus is on building a secure, scalable, and maintainable dashboard using best practices from both Laravel and Nuxt ecosystems.
