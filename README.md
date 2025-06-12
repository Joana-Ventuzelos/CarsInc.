# CarsInc. - Laravel Rental Car System

CarsInc. is a Laravel-based web application for managing car rentals, payments, reservations, and user accounts. It provides a modern, user-friendly interface for both customers and administrators, supporting ATM payments, reservation confirmation by email, and PDF generation for rental details.

## Features

- **Car Reservation:** Users can browse available cars, select rental dates, and reserve vehicles.
- **Pickup Locations:** All available pickup locations (cidades/filiais) are shown when making a reservation.
- **Payment Integration:** Supports ATM payment flows.
- **Reservation Confirmation:** After payment, users select a pickup location and receive a confirmation email.
- **PDF Generation:** Users are redirected to a downloadable PDF with all reservation details (no "N/A" values).
- **Email Notifications:** Reservation confirmation emails are sent using SMTP (Mailtrap or Brevo/Sendinblue supported).
- **Admin Panel:** Admins can manage cars, users, and view all reservations.
- **Reservation History:** Users can view their past and current reservations, with links to car details.

## Setup Instructions

1. **Clone the repository and install dependencies:**
   ```sh
   git clone <https://github.com/Joana-Ventuzelos/CarsInc..git>
   cd CarsInc.
   composer install
   npm install && npm run build
   ```
2. **Configure your environment:**
   - Copy `.env.example` to `.env` and set your database and mail credentials.
   - For Mailtrap (development):
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=sandbox.smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_mailtrap_username
     MAIL_PASSWORD=your_mailtrap_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=your@email.com
     MAIL_FROM_NAME=CarsInc.
     ```
   - For Brevo/Sendinblue (production):
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp-relay.brevo.com
     MAIL_PORT=587
     MAIL_USERNAME=your_brevo_username
     MAIL_PASSWORD=your_brevo_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=your@email.com
     MAIL_FROM_NAME=CarsInc.
     ```
3. **Run migrations and seeders:**
   ```sh
   php artisan migrate --seed
   ```
4. **Clear and cache config:**
   ```sh
   php artisan config:clear
   php artisan config:cache
   ```
5. **Start the development server:**
   ```sh
   php artisan serve
   ```

## Usage
- Register or log in as a user.
- Browse available cars and make a reservation.
- Select a pickup location and payment method.
- After payment, receive a confirmation email and download your reservation PDF.
- View your reservation history and car details.

## Technologies Used
- Laravel (PHP)
- MySQL
- Tailwind CSS
- ATM SDK
- Barryvdh DomPDF (PDF generation)
- Mailtrap/Brevo (SMTP email)

## License
This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---
For any issues or contributions, please open an issue or pull request on the repository.
