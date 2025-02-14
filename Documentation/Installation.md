# **Installation Guide**

This project can be set up in two ways: using Docker or directly on a web server.

---

## 1. **Using Docker**

To run the project with Docker, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/ICWR-TEAM/R-WFW
   cd R-WFW
   composer install
   ```

2. **Start the Application:**
   Run the following command to start the application using Docker:
   ```bash
   ./start.sh
   ```

---

## 2. **Using a Web Server (Apache, Nginx, etc.)**

If you want to run the project directly on a web server, follow these steps:

1. **Copy the `app/` Directory:**
   Move the entire `app/` directory to a location outside of the web server’s root directory.

2. **Configure the Web Server:**
   Place the `public/` directory inside the root directory of your web server (e.g., `/var/www/html` for Apache/Nginx).

---

## 3. **Using Composer**

If you want to install the `icwr-team/r-wfw` package directly via Composer, run the following command in your project’s root directory:

```bash
composer require icwr-team/r-wfw -W
```

The `-W` flag tells Composer to update all dependencies, ensuring compatibility across the entire project.

After installation, continue with the setup as described above.
