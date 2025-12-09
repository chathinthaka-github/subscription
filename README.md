# Subscription Management System

A production-level subscription management system with Laravel UI and Pure PHP backend processing.

## Architecture

- **Laravel UI** (`laravel_ui/`): Admin interface built with Laravel 12, Blade templates, Tailwind CSS v4, and Spatie Laravel Permission
- **Pure PHP System** (`subscription_sys/`): Standalone subscription processing with RabbitMQ workers
- **Shared Database**: MySQL database shared between both systems

## Features

### Laravel UI Modules

- 1 **Login Form**: username/password
- 2 **Dashboard**: overview of subscriptions and MTs with charts. Dropdowns include:

	• Service Configuration — Service, Service Message
	• Schedules — Renewal Plan
	• Reports — search by date range, service, MSISDN, and status (renewal_job, subscription, mt)
	• Admin — User, Role, and Permission management

- 3 **Service Configuration UI**: create, update, delete, index (search by shortcode, keyword)
- 4 **Service Message UI**: create, update, delete, index (search by shortcode, keyword)
- 5 **Renewal Plan UI**: create, update, delete, index (search by shortcode, keyword)
- 6 **Admin User UI**: create (username, password, status, role), update, delete, index with search; display roles and permissions
- 7 **Admin Role UI**: create (admin, manager, marketing, developer), update, delete, index with search; assign and display permissions
- 8 **Admin Permission UI**: create, update, delete, index (modules: service, service message, renewal plan, reports); assign roles from here

### Pure PHP System Modules

- 1 **API - Subscription**: Receive subscription requests, validate, process, and enqueue to RabbitMQ
- 2 **Worker - Subscription**: process and insert into table; if FPMT is enabled, generate and enqueue an MT record in RabbitMQ
- 3 **Worker - MT**: process, call external API (Telecom API), and insert a record into the MT table; (dn_status and dn_details remain pending)
- 4 **API - DN**: Receive delivery notifications from Telecom API, then process and enqueue into RabbitMQ
- 5 **Worker - DN**: process and updates MT status by mt_ref_id
- 6 **Worker - Renewal**: Checks due renewals every minute (renewal_plan and subscription), generate MT data into RabbitMQ; set renewal_job status to queued; once the MT worker processes it, update the job to done
- 7 **Subscription Page**: input MSISDN → call subscription API → show success/fail message on the same or next page (hide MSISDN input after submission)
- 8 **Emulator Page**: list all mt_ref_id values and allow clicking a button to trigger DN


Technical Notes

	• Use MySQL, PHP, RabbitMQ, Supervisor (for workers), Laravel, DB migrations, and table indexing.
	• Ensure proper validation in all modules.
