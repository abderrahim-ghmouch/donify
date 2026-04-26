<p align="center">
  <img src="public/images/donifylg.png" alt="Donify Logo" width="180"/>
</p>

<h1 align="center">DONIFY</h1>

<p align="center">
  <em>The Institutional Crowdfunding Platform for High-Impact Missions.</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/Stripe-Payment_Gateway-635BFF?style=for-the-badge&logo=stripe&logoColor=white" alt="Stripe">
  <img src="https://img.shields.io/badge/PostgreSQL-Database-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/License-MIT-064e3b?style=for-the-badge" alt="License">
</p>

---

## Overview

**Donify** is a secure, high-performance crowdfunding platform engineered to connect verified mission leaders ("Porters") with institutional and individual donors. The platform is built on a disciplined, approval-based architecture that ensures every campaign published on the platform meets institutional standards before reaching the public.

Donify is not a generic donation tool. It is a **structured impact gateway** designed for organizations that demand transparency, traceability, and institutional authority in their philanthropic operations.

<p align="center">
  <img src="public/images/slogan.png" alt="Donify — Be the Change" width="420"/>
</p>

---

## Table of Contents

- [Key Features](#key-features)
- [Architecture & Design Philosophy](#architecture--design-philosophy)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Role-Based Access Control](#role-based-access-control)
- [Payment Infrastructure](#payment-infrastructure)
- [API Reference](#api-reference)
- [Design System (Graphic Charter)](#design-system-graphic-charter)
- [Contributing](#contributing)
- [License](#license)

---

## Key Features

| Feature                        | Description                                                                                                                                          |
| ------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Mission Registry**           | Porters can initialize, manage, and monitor campaigns through a dedicated production dashboard.                                                      |
| **Admin Authorization**        | Every campaign enters a `pending` state and requires explicit admin approval before going live.                                                      |
| **Secure Donation Gateway**    | Stripe-powered checkout sessions with MAD (Moroccan Dirham) support. Donify never stores card data.                                                  |
| **Sector Filtering**           | Donors can instantly discover missions by category through a real-time search and filter interface.                                                  |
| **Watchlist Protocol**         | Users can build a personal portfolio of tracked missions via the Favourites system.                                                                  |
| **Institutional Registration** | Organizations register through a cinematic, multi-step onboarding portal with manual admin verification.                                             |
| **JWT Authentication**         | Stateless, token-based authentication for all API interactions, ensuring secure and scalable access management.                                      |
| **Multi-Provider Payments**    | A future-proof `payments` table with JSON metadata support allows for seamless integration of PayPal, CMI, or bank transfers without schema changes. |

---

## Architecture & Design Philosophy

Donify is built around three core architectural principles:

**1. Separation of Concerns**
Business logic is strictly separated from the presentation layer. All data is served through a RESTful JSON API consumed by the frontend via a bespoke `ApiClient` wrapper—the same client a mobile app would use.

**2. Future-Proof Payment Layer**
Rather than hardcoding payment credentials into the donations table, Donify uses a dedicated `payments` table as a universal transaction log. Adding a new payment provider in the future requires zero schema migrations.

**3. Institutional Security Model**
No campaign is public by default. The three-tier role system (`admin`, `porter`, `user`) ensures that every mission on the platform has been reviewed and authorized by a verified administrator.

---

## Technology Stack

| Layer                 | Technology                                 |
| --------------------- | ------------------------------------------ |
| **Backend Framework** | Laravel 13.x (PHP 8.3)                     |
| **Frontend Styling**  | Tailwind CSS (Utility-First)               |
| **Database**          | PostgreSQL                                 |
| **Authentication**    | JWT (via `php-open-source-saver/jwt-auth`) |
| **Payment Gateway**   | Stripe SDK (`stripe/stripe-php`)           |
| **Asset Storage**     | Laravel Storage (Local / S3-compatible)    |
| **Typography**        | Quicksand (Google Fonts)                   |

---

## System Requirements

- PHP **8.2** or higher
- Composer **2.x**
- Node.js **18.x** and NPM
- PostgreSQL **14+** (or any Laravel-supported database)
- A **Stripe Account** (Test mode for development)

---

## Installation

**1. Clone the repository**

```bash
git clone https://github.com/abderrahim-ghmouch/donify.git
cd donify
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Install Node.js dependencies and build assets**

```bash
npm install && npm run build
```

**4. Configure the environment**

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

**5. Run database migrations**

```bash
php artisan migrate
```

**6. Link public storage**

```bash
php artisan storage:link
```

**7. Start the development server**

```bash
php artisan serve
```

---

## Configuration

After copying `.env.example`, update the following critical keys before running the platform:

```env
# Application
APP_NAME=Donify
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=donify
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Stripe Payment Gateway
STRIPE_KEY=pk_test_your_publishable_key
STRIPE_SECRET=sk_test_your_secret_key

# JWT
JWT_SECRET=generate_via_artisan_jwt_secret
```

---

## Role-Based Access Control

Donify enforces a strict three-tier access model:

| Role     | Description                                                                                           |
| -------- | ----------------------------------------------------------------------------------------------------- |
| `admin`  | Full platform control. Authorizes campaigns, manages users, and oversees all financial activity.      |
| `porter` | Mission creator. Can submit campaigns for review and track funding progress via the Porter Dashboard. |
| `user`   | Verified donor. Can browse missions, pledge support, and manage a personal watchlist.                 |

---

## Payment Infrastructure

Donify uses a **provider-neutral payment architecture**:

1. **Intent**: A `donation` record is created in `pending` state upon checkout initiation.
2. **Gateway**: The donor is redirected to a secure, Stripe-hosted payment page. Donify **never handles raw card data**, ensuring full PCI compliance.
3. **Confirmation**: A Stripe Webhook listener verifies the payment and automatically marks the donation as `completed`, updating the campaign's funded total.
4. **Extensibility**: All transaction metadata is stored in a JSON column (`provider_data`) in the `payments` table, making it straightforward to add PayPal, CMI, or other providers.

---

## API Reference

All API routes are prefixed with `/api` and require a valid JWT Bearer token unless otherwise noted.

| Method   | Endpoint                     | Auth     | Description                                    |
| -------- | ---------------------------- | -------- | ---------------------------------------------- |
| `POST`   | `/api/login`                 | Public   | Authenticate and receive JWT token.            |
| `POST`   | `/api/register`              | Public   | Register a new donor account.                  |
| `GET`    | `/api/campaigns`             | Public   | List all active, authorized campaigns.         |
| `GET`    | `/api/campaigns/{id}`        | Public   | Retrieve a single campaign's details.          |
| `POST`   | `/api/campaigns/{id}/donate` | Required | Initiate a Stripe Checkout Session.            |
| `GET`    | `/api/favourites`            | Required | List the authenticated user's saved campaigns. |
| `POST`   | `/api/favourites`            | Required | Add a campaign to the watchlist.               |
| `DELETE` | `/api/favourites/{id}`       | Required | Remove a campaign from watchlist.              |

---

## Design System (Graphic Charter)

All contributors must strictly adhere to the **Luxury Raja** visual identity.

| Token                  | Value                             | Usage                              |
| ---------------------- | --------------------------------- | ---------------------------------- |
| `--color-off-black`    | `#1A1A1A`                         | Primary text, dark surfaces        |
| `--color-forest-green` | `#064e3b`                         | Brand accent, CTAs, highlights     |
| `--color-emerald`      | `#059669`                         | Interactive states, progress bars  |
| `--color-gold`         | `#DAA520`                         | Premium accents, watchlist states  |
| `--color-surface`      | `#fbf8f6`                         | Card backgrounds, data zones       |
| **Typeface**           | Quicksand                         | All UI text (Bold + Black weights) |
| **Border Radius**      | `rounded-xl` / `rounded-[2.5rem]` | Cards, inputs, modals              |

---

## Contributing

Contributions that align with the platform's institutional mission and design philosophy are welcome.

1. Fork the repository.
2. Create your feature branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m 'feat: describe your feature'`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Open a Pull Request against the `main` branch.

Please ensure that all submitted code adheres to the **Luxury Raja** graphic charter and does not introduce inline styles or override existing design tokens.

---

## License

This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for full details.

---

<p align="center">
  <b>Donify — Empowering The Architecture of Change.</b><br>
  <sub>Built with precision. Designed for impact.</sub>
</p>
