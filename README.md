# DONIFY — CROWDFUNDING PLATFORM

![Donify Platform](public/images/donifylg.png)

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
* **Stripe Integration**: Secure payment processing with Stripe Checkout for donations.
* **Stripe Connect**: Payout system for campaign creators to receive funds directly to their Stripe accounts.
* **Multi-role System**: Support for Donors, Porters, Organizations, and Administrators.
* **Campaign Management**: Full CRUD operations with approval workflow and status tracking.
* **Image Gallery**: Multiple image uploads for campaigns with polymorphic relationships.

---

## 🎨 Design System

### Color Palette
- **Primary**: Emerald Green (#064e3b) - Trust, growth, and sustainability
- **Secondary**: Gold (#996515) - Premium quality and value
- **Background**: Cream (#fbf8f6) - Soft, welcoming atmosphere
- **Text**: Deep Black (#1A1A1A) - High contrast readability

### Typography
- **Primary Font**: Nunito - Soft, friendly, and approachable
- **Secondary Font**: Quicksand - Modern and clean
- **Accent Font**: Outfit - Bold and impactful

### Visual Effects
- Soft green blur backgrounds for depth
- Smooth transitions and hover effects
- Rounded corners with small border radius
- Subtle shadows and gradients

---

## 🏗 Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Core Framework** | [Laravel 11.x](https://laravel.com) |
| **Frontend Styling** | [Tailwind CSS](https://tailwindcss.com) |
| **Authentication** | [JWT-Auth](https://github.com/PHP-OpenSource-Saver/jwt-auth) |
| **Payment Processing** | [Stripe API](https://stripe.com) |
| **Database** | MySQL / PostgreSQL |
| **Typography** | Nunito, Quicksand, Outfit |
| **JavaScript** | Vanilla JS (API Client Pattern) |

---

## 📁 Project Structure

```
donify/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CampaignController.php
│   │   │   ├── DonationController.php
│   │   │   ├── UserController.php
│   │   │   ├── OrganisationController.php
│   │   │   ├── StripeConnectController.php
│   │   │   └── StripeWebhookController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── PorterMiddleware.php
│   │       ├── DonorMiddleware.php
│   │       └── CheckBanned.php
│   └── Models/
│       ├── User.php
│       ├── Campaign.php
│       ├── Donation.php
│       ├── Organisation.php
│       ├── Payment.php
│       ├── Payout.php
│       └── Stripe.php
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── profile.blade.php
│       ├── porter/
│       │   ├── dashboard.blade.php
│       │   └── create.blade.php
│       ├── campaigns/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       └── admin/
│           └── dashboard.blade.php
└── public/
    └── js/
        ├── api-client.js
        └── script.js
```

---

## 🚀 Deployment Instructions

### System Requirements
* PHP 8.2+
* Node.js & NPM
* Composer
* MySQL 8.0+ or PostgreSQL 13+
* Stripe Account (for payment processing)

### Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-repo/donify.git
cd donify

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Configure environment
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 4. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=donify
DB_USERNAME=root
DB_PASSWORD=

# 5. Configure Stripe in .env
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=your_webhook_secret

# 6. Run migrations and seed database
php artisan migrate --seed
php artisan storage:link

# 7. Start development server
php artisan serve

```

---

## 👥 User Roles

### Donor
- Browse and search campaigns
- Make donations via Stripe
- Add campaigns to favorites
- View donation history
- Update profile information

### Porter (Campaign Creator)
- Create and manage one campaign (individuals)
- Upload campaign images
- Track donations and analytics
- Request payouts via Stripe Connect
- View available balance for payout

### Organization
- Create and manage multiple campaigns
- Verification required by admin
- Same payout capabilities as porters
- Enhanced credibility badge

### Administrator
- Approve/reject campaigns
- Verify organizations
- Ban/unban users
- Manage categories
- Full platform oversight

---

## 🔐 Security Features

- **JWT Authentication**: Secure token-based authentication
- **Role-based Access Control**: Middleware protection for routes
- **Ban System**: Ability to restrict malicious users
- **Verification Flow**: Manual approval for organizations and campaigns
- **Stripe Security**: PCI-compliant payment processing
- **CSRF Protection**: Laravel's built-in CSRF protection
- **SQL Injection Prevention**: Eloquent ORM with prepared statements

---

## 💳 Payment Flow

### Donation Process
1. User selects campaign and enters amount
2. Stripe Checkout session created
3. User completes payment on Stripe
4. Webhook confirms payment
5. Campaign balance updated
6. Donation marked as completed

### Payout Process
1. Porter connects Stripe Express account
2. Porter requests payout from campaign
3. System validates available balance
4. Stripe Transfer created to porter's account
5. Payout marked as completed

---

## 📊 Database Schema

### Key Tables
- **users**: User accounts (donors, porters, admins)
- **organisations**: Verified institutional accounts
- **campaigns**: Fundraising campaigns
- **donations**: Individual donation records
- **payments**: Stripe payment tracking
- **payouts**: Transfer records to creators
- **favourites**: User's saved campaigns
- **categories**: Campaign categorization
- **images**: Polymorphic image storage
- **stripes**: Stripe Connect account data

---

## 🛠 API Endpoints

### Authentication
```
POST /api/register          - Register new user
POST /api/login             - User login
POST /api/logout            - User logout
GET  /api/me                - Get current user
POST /api/refresh           - Refresh JWT token
```

### Campaigns
```
GET    /api/campaigns              - List active campaigns
POST   /api/campaigns              - Create campaign (auth)
GET    /api/campaigns/{id}         - View campaign details
PUT    /api/campaigns/{id}         - Update campaign (owner/admin)
DELETE /api/campaigns/{id}         - Delete campaign (owner/admin)
GET    /api/campaigns/my           - Porter's campaigns (auth)
POST   /api/campaigns/{id}/approve - Approve campaign (admin)
POST   /api/campaigns/{id}/reject  - Reject campaign (admin)
```

### Donations
```
POST /api/campaigns/{id}/donate    - Create donation
POST /api/campaigns/{id}/confirm   - Confirm payment
GET  /api/donations/my             - User's donations (auth)
```

### Organizations
```
GET  /api/organisations            - List verified orgs
POST /api/organisations/register   - Register organization
POST /api/organisations/{id}/verify - Verify org (admin)
```

### Stripe
```
GET  /api/stripe/status            - Check connection status
POST /api/stripe/onboarding        - Start Stripe onboarding
POST /api/campaigns/{id}/payout    - Request payout
```

---

## 🎨 UI Components

### Reusable Elements
- **Campaign Cards**: Responsive grid layout with images
- **Modal Forms**: Smooth animations for campaign creation
- **Toast Notifications**: Floating success/error messages
- **Loading States**: Skeleton screens and spinners
- **Progress Bars**: Visual funding progress indicators
- **Avatar Upload**: Drag-and-drop image upload

### Design Patterns
- **Mobile-first**: Responsive design for all screen sizes
- **Accessibility**: ARIA labels and keyboard navigation
- **Performance**: Lazy loading and optimized images
- **Consistency**: Unified color scheme and typography

---

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run specific test
php artisan test --filter=CampaignTest
```

---

## 🚧 Roadmap

- [ ] Email notifications for campaign updates
- [ ] Social media sharing integration
- [ ] Campaign comments and updates
- [ ] Advanced analytics dashboard
- [ ] Multi-currency support
- [ ] Recurring donations
- [ ] Campaign milestones
- [ ] Mobile app (React Native)

---

## 📝 License

This project is licensed under the MIT License.

---

## 👨‍💻 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📧 Contact

For questions or support, please contact:
- **Email**: support@donify.com
- **Website**: https://donify.com

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Stripe API
- JWT-Auth Package
- Google Fonts (Nunito, Quicksand, Outfit)

---

**Built with ❤️ for making a difference**
