# transportation-

## Detailed Windows Installation Guide

This guide provides detailed steps to set up this Laravel project on a Windows machine.

### Prerequisites

Before starting, ensure you have the following installed on your system:

1.  **PHP** (8.2 or higher)
    *   Download the "Thread Safe" ZIP file from [windows.php.net](https://windows.php.net/).
    *   Extract it to `C:\php`.
    *   Add `C:\php` to your Windows System **PATH** environment variable.
    *   Rename `php.ini-development` to `php.ini` in `C:\php`.
    *   Enable required extensions in `php.ini` by removing the `;` (semicolon) from: `extension=pdo_sqlite`, `extension=curl`, `extension=openssl`, `extension=mbstring`.

2.  **Composer** (PHP Dependency Manager)
    *   Download and run the installer from [getcomposer.org](https://getcomposer.org/).
    *   It will automatically detect your PHP installation and add Composer to your **PATH**.

3.  **Node.js & NPM**
    *   Download and install the "LTS" version from [nodejs.org](https://nodejs.org/). This includes NPM automatically.

4.  **Database Server**
    *   **Recommended (Easiest):** Download and install [XAMPP](https://www.apachefriends.org/index.html), which provides a bundled MariaDB server, or use the project's default **SQLite** (no installation required).

---

### Step-by-Step Installation

1.  **Clone the Project:**
    Open PowerShell or CMD, navigate to your desired directory, and run:
    ```bash
    git clone https://github.com/digitalpentech-art/transportation-.git
    cd transportation-
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Setup Environment File:**
    ```bash
    copy .env.example .env
    ```
    *   Open `.env` in a text editor (Notepad, VS Code).
    *   Update database settings:
        ```text
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_db_name
        DB_USERNAME=root
        DB_PASSWORD=
        ```
    *   Create `your_db_name` database in your MySQL tool (e.g., phpMyAdmin via XAMPP).

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Install Frontend Dependencies & Compile:**
    ```bash
    npm install
    npm run build
    ```

6.  **Run Migrations and Seeders:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Serve the Application:**
    ```bash
    php artisan serve
    ```
    Open your browser to `http://127.0.0.1:8000`.
