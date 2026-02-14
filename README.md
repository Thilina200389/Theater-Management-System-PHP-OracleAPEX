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

## 📸 Interface Preview
![Admin Dashboard](screenshots/admin_dashboard.png)
*The centralized dashboard showcasing movie and theater statistics.*

## 🚀 Setup & Installation
1.  Clone the repository to your local `www/` or `htdocs/` folder.
2.  Ensure your Oracle APEX REST endpoints are active.
3.  Configure the `API_BASE_URL` in `Config/connector.php`.
4.  Run the application via `localhost/Theater-Management-System-PHP-OracleAPEX/index.php`.

---
*Developed by Thilina Sandakelum Wijesinghe for the Database Implementation module | Department fo Software Technology at the University of Vocational Technology (UoVT)*
