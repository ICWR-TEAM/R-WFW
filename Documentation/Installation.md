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

## **3. Using Composer**  

You can install the `icwr-team/r-wfw` package directly using Composer. Choose one of the following methods based on your preference:  

### **1. Install in the Current Directory**  
If you want to install the package in the current directory, run:  
```bash
composer create-project icwr-team/r-wfw
```  
> ⚠️ Ensure the directory is empty or does not contain conflicting files before running this command.  

---

### **2. Install in a Specific Directory (`my-project`)**  
If you prefer to install the package inside a separate directory called `my-project`, use:  
```bash
composer create-project icwr-team/r-wfw my-project
```  
> This will create a new `my-project/` folder and install all required files inside it.  

After installation, proceed with the setup steps mentioned earlier to configure your environment properly. 🚀
