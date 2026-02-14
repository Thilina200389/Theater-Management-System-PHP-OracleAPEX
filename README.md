# Theater Management System (TMS) 🎬

A comprehensive web-based management solution designed for modern cinema operations. This project utilizes an **MVC architecture** in PHP to interact with a centralized **Oracle APEX** database via **RESTful APIs**.

## Key Features
* **Admin Dashboard:** Real-time visualization of total revenue, tickets sold, and active movies/theaters.
* **Complete CRUD Modules:** Dedicated management for Movies, Schedules, Theaters, Screens, and Users.
* **Secure Authentication:** Built-in login/logout functionality.
* **RESTful Data Fetching:** Seamless data exchange using `curl` to interact with Oracle REST Data Services (ORDS).

## Tech Stack
* **Backend:** PHP (MVC Architecture)
* **Database Backend:** Oracle APEX (REST Enabled)
* **Frontend:** HTML5, CSS3, JavaScript
* **API Communication:** JSON via Oracle REST Data Services (ORDS)

## Database Architecture
This project implements a relational database schema optimized for high-performance cinema management. Key components include:
* **Data Definition:** Complete DDL scripts for tables like `Movies`, `Bookings`, `Schedules`, and `Theaters`.
* **Business Logic:** Server-side triggers and constraints to ensure data integrity during booking transactions.
* **API Integration:** Oracle REST Data Services (ORDS) enabled on all core entities for seamless PHP connectivity.

## Interface Preview
![Admin Dashboard](screenshots/admin_dashboard.png)
*The centralized dashboard - movie and theater statistics.*

## Setup & Installation
1.  Clone the repository to your localhost `www/` or `htdocs/` folder.
2.  Ensure your Oracle APEX REST endpoints are active.
3.  Configure the `API_BASE_URL` in `Config/connector.php`.
4.  use `TMS.sql` for create tables.
5.  Run the application via `localhost/Theater-Management-System-PHP-OracleAPEX/index.php`.
6.  Login: username `admin`, password `admin123`

---
*Developed by Thilina Sandakelum Wijesinghe for the Database Implementation module | Department fo Software Technology at the University of Vocational Technology (UoVT)*
