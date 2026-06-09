# WFP Classroom — Portal Kesehatan

A **health portal management system** built with **Laravel 10** as part of the Web Framework Programming (WFP) course. This application supports management of healthcare services, categories, doctors, articles, and patient transactions.

---

## ✨ Features

- 🏥 **Service Management** — CRUD for health services with category tagging and pricing
- 📂 **Category Management** — Manage service categories with image support
- 👨‍⚕️ **Doctor Management** — Add and manage doctor profiles
- 📰 **Article Management** — Publish health-related articles
- 💳 **Transaction Management** — Record and manage patient service transactions (Many-to-Many with Services)
- 🔐 **Authentication** — User login/register via `laravel/ui`

---

## 🛠️ Tech Stack

| Layer       | Technology                  |
| ----------- | --------------------------- |
| Framework   | Laravel 10                  |
| Language    | PHP ^8.1                    |
| Database    | MySQL                       |
| Frontend    | Blade + AdminLTE            |
| Auth        | Laravel UI (Bootstrap Auth) |
| HTTP Client | Guzzle 7                    |

---

## ⚙️ Requirements

Before cloning this project, make sure you have the following installed:

- **PHP** >= 8.1
- **Composer** >= 2.x
- **MySQL** >= 5.7 / MariaDB >= 10.3
- **Node.js** >= 16.x & **npm**
- A local web server (e.g., **XAMPP**, **Laragon**, or **Herd**)

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Blurryface275/WFP-Classroom.git
cd WFP-Classroom
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Set up environment file

```bash
cp .env.example .env
```

Then open `.env` and update the following values to match your local setup:

```env
APP_NAME="Portal Kesehatan"
APP_URL=http://localhost/laravel10/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel10       # create this database first in phpMyAdmin / MySQL
DB_USERNAME=root
DB_PASSWORD=                # leave empty for XAMPP default
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Run database migrations

```bash
php artisan migrate
```

### 7. (Optional) Seed the database with sample data

```bash
php artisan db:seed
```

This will populate the database with sample categories, services, doctors, articles, transactions, and a default user account.

### 8. Build frontend assets

```bash
npm run dev
```

> For production: `npm run build`

### 9. Set storage permissions (Linux/Mac only)

```bash
chmod -R 775 storage bootstrap/cache
```

---

## 🌐 Accessing the Application

If using **XAMPP**, place the project inside `C:\xampp\htdocs\` and access it at:

```
http://localhost/laravel10/public
```

If using `php artisan serve`:

```bash
php artisan serve
```

Then visit: `http://127.0.0.1:8000`

---

## 📁 Project Structure (Key Directories)

```
laravel10/
├── app/
│   ├── Http/Controllers/     # Controllers (Category, Service, Doctor, etc.)
│   └── Models/               # Eloquent Models
├── database/
│   ├── migrations/           # Database schema definitions
│   └── seeders/              # Sample data seeders
├── resources/
│   └── views/                # Blade templates (AdminLTE layout)
└── routes/
    └── web.php               # All web routes
```

---

## 🗂️ Available Routes

| Method | URI                   | Description               |
| ------ | --------------------- | ------------------------- |
| GET    | `/`                   | Landing page              |
| GET    | `/home`               | Dashboard (requires auth) |
| \*     | `/services`           | Services CRUD             |
| \*     | `/category`           | Categories CRUD           |
| \*     | `/doctor`             | Doctors CRUD              |
| \*     | `/transaction`        | Transactions CRUD         |
| \*     | `/article`            | Articles CRUD             |
| GET    | `/login`, `/register` | Authentication pages      |

> `*` means all standard RESTful routes (index, create, store, show, edit, update, destroy)

---

## 🔑 Default Seeded Account

After running `php artisan db:seed`, you can log in with:

| Field    | Value               |
| -------- | ------------------- |
| Email    | `admin@example.com` |
| Password | `password`          |

> ⚠️ Change these credentials immediately in a production environment.

---

## 📦 Key Packages

| Package             | Purpose                      |
| ------------------- | ---------------------------- |
| `laravel/ui`        | Auth scaffolding (Bootstrap) |
| `laravel/sanctum`   | API token authentication     |
| `guzzlehttp/guzzle` | HTTP client                  |
| `fakerphp/faker`    | Fake data for seeding        |

---

## 🤝 Contributing

1. Fork this repository
2. Create your feature branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m 'feat: add your feature'`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a Pull Request

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
