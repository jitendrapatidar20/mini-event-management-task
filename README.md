🎟️ Event Booking Task — Laravel 8 + MySQL
    Developed by Jitendra Kumar Patidar

📘 Overview
A Mini Event Booking Task built using Laravel 8 and MySQL.
The application provides a secure authentication system, event management by admin users, booking functionality for normal users, and enhanced administrative capabilities like login tracking, audit management, and dynamic project configuration.

🚀 Core Features
  🔐 Authentication & Authorization

    Laravel Breeze authentication with email-based password reset.
    Role-based access: Admin and User.
    Admin-only event management dashboard.
    Secure email verification & password recovery via SMTP.


🗓️ Event Management (Admin Only)

Full CRUD operations for events.
Event fields:
title, description, start_time, end_time, location, total_seats, available_seats, slug.
Dynamic slug generation using cviebrock/eloquent-sluggable.
Validation ensures correct scheduling, available seats, and proper data format.


🎫 Booking System (Users)

Authenticated users can:

View a list of available events.
Search events by title or location.
Book seats within availability.
View their own bookings.
Cancel bookings (soft delete).

Prevents:
Overbooking (respects available_seats).
Booking for past events.
Duplicate bookings by the same user.


🔒 Advanced Admin Features
  📧 Forgot Password by Email

    Built-in Laravel password reset notification system.
    Configurable via .env or dynamic project settings.

🧾 Dynamic Slug Generation

Each event automatically generates a unique slug based on its title.
If the title changes, the slug updates only if required.

🚫 IP Blocking After 4 Failed Login Attempts
    Brute-force protection using throttle:4,5 middleware.
    Temporarily blocks IP for 5 minutes after 4 failed attempts.


🌍 Login History Management
Tracks and stores user login activity:

IP Address
    Device Platform Browser
    Latitude & Longitude (via IP Geolocation API)
    Stored in a login_histories table.
    Updates users.last_login_ip and users.last_login_at.
    Uses Jenssegers/Agent for device info parsing.


🧠 Audit Management (System-wide Logging)

    Custom Auditable Trait to log:
    Create, update, delete operations across models.
    Stores:
    User performing the action
    Model type, model ID
    Old and new data (JSON)
    Uses dedicated audits table.
    Can be extended with Spatie Activity Log or Laravel Telescope.


⚙️ Dynamic Project Settings (Database-Based)

Centralized project_settings table manages key-value configuration.
Stores:
Project Name
Support Email
SMTP credentials
Footer Text
Social Links


🛡️ Security & Best Practices

CSRF protection on all POST requests.
Rate limiting for authentication routes.
Input validation and sanitization.
Soft deletes for recoverable data.
Data audit trails ensure accountability.


🧩 Models & Relationships
ModelDescriptionRelationshipsUserApplication users (Admin / Member).Has many Bookings, Has many LoginHistoriesEventEvent data and seat tracking.Has many BookingsBookingStores event-user relations with seats booked.Belongs to User & EventLoginHistoryTracks login attempts and user devices.Belongs to UserAuditStores data change history.Belongs to UserProjectSettingManages dynamic project constants.—

🧰 Tech Stack

Laravel 8
PHP 8+
MySQL 8
Bootstrap 5
Laravel Breeze / Sanctum
Eloquent ORM
Jenssegers/Agent (Device tracking)
cviebrock/eloquent-sluggable (Slug generation)
Cache (for settings and performance)


✅ Feature Checklist
FeatureStatusUser Authentication + Email Reset
✅Event CRUD (Admin)
✅Seat Booking (User)
✅Dynamic Slug Generation
✅IP Lock After 4 Failed Logins
✅Login History Tracking
✅Audit Management
✅Dynamic Project Settings (DB)
✅Soft Deletes
✅Validation & Security✅

