# DONIFY — CROWDFUNDING PLATFORM

**Donify** is a secure, high-performance crowdfunding platform designed to connect campaign creators ("Porters") with donors. The platform utilizes a formal **Emerald and Gold** design system to ensure architectural clarity, high-contrast readability, and a professional user experience.

---

## 🏛 Platform Overview

Donify facilitates the deployment and management of impactful initiatives through a structured, review-driven system.

### Core Features
* **Campaign Discovery**: A central dashboard for donors to search, filter, and analyze active campaigns.
* **Watchlist System**: A personalized tracking feature for monitoring specific initiatives.
* **Real-time Analytics**: Telemetry and data visualization for campaign progress and funding status.
* **Creator Dashboard**: A dedicated interface for Porters to initialize campaigns and manage their portfolio.
* **Institutional Authentication**: A secure registration and manual authorization flow for organizations.

---

## 🏗 Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Core Framework** | [Laravel 11.x](https://laravel.com) |
| **Frontend Styling** | [Tailwind CSS](https://tailwindcss.com) |
| **Authentication** | [JWT-Auth](https://github.com/PHP-OpenSource-Saver/jwt-auth) |
| **Database** | MySQL / PostgreSQL |
| **Typography** | Quicksand |

---

## 🚀 Deployment Instructions

### System Requirements
* PHP 8.2+
* Node.js & NPM
* Composer

### Installation Steps

```bash
# 1. Clone the repository
git clone [https://github.com/your-repo/donify.git](https://github.com/your-repo/donify.git)
cd donify

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Configure environment
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 4. Run migrations and link storage
php artisan migrate --seed
php artisan storage:link