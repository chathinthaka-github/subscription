# Database — Laravel Migrations

Make sure to add any missing fields or tables if necessary.

## 1. service
- id  
- shortcode  
- keyword  
- status  
- FPMT (yes/no)

## 2. service_message
- id  
- service_id  
- status  
- message_type (FPMT, RENEWAL)  
- message (max 260 chars, textarea with counter)  
- price_code  
- created_at  
- updated_at  

## 3. subscription
- id  
- msisdn  
- service_id  
- status  
- subscribed_at (datetime)  
- created_at (datetime)  
- updated_at (datetime)  
- last_renewal_at (datetime)  
- next_renewal_at (datetime)  
- renewal_plan_id  

## 4. renewal_plan
- id  
- service_id  

### Plans
- daily  
- weekly  
- monthly  

### Daily plan
- subscription datetime or fixed time  
- option to skip subscription day (on/off)  

### Weekly plan
- select any days of the week  
- subscription datetime or fixed time  
- option to skip subscription day (on/off)  

### Monthly plan
- select any days of the month  
- subscription datetime or fixed time  
- option to skip subscription day (on/off)  

## 5. renewal_job
- id  
- service_id  
- renewal_plan_id  
- subscription_id  
- msisdn  
- status  
- created_at  
- updated_at  

## 6. mt
- id  
- service_id  
- subscription_id  
- message  
- message_type  
- status (success/fail)  
- dn_status (pending/success/fail)  
- dn_details  
- created_at  
- updated_at  
- msisdn  
- price_code  
- mt_ref_id  

---

# Laravel UI

## 1. Login Form
- username  
- password  

## 2. Dashboard
- Overview of subscriptions and MTs with charts  

### Dropdowns
- Service Configuration  
  - Service  
  - Service Message  
- Schedules  
  - Renewal Plan  
- Reports  
  - Search by date range  
  - Service  
  - MSISDN  
  - Status (renewal_job, subscription, mt)  
- Admin  
  - User management  
  - Role management  
  - Permission management  

## 3. Service Configuration UI
- create  
- update  
- delete  
- index (search by shortcode, keyword)  

## 4. Service Message UI
- create  
- update  
- delete  
- index (search by shortcode, keyword)  

## 5. Renewal Plan UI
- create  
- update  
- delete  
- index (search by shortcode, keyword)  

## 6. Admin User UI
- create (username, password, status, role)  
- update  
- delete  
- index with search  
- display roles and permissions  

## 7. Admin Role UI
- create (admin, manager, marketing, developer)  
- update  
- delete  
- index with search  
- assign and display permissions  

## 8. Admin Permission UI
- create  
- update  
- delete  
- index  

### Modules
- service  
- service message  
- renewal plan  
- reports  

- assign roles from here  

---

# System — Pure PHP

## 1. API - Subscription
- process and enqueue into RabbitMQ  

## 2. Worker - Subscription
- process and insert into table  
- if FPMT is enabled, generate and enqueue an MT record in RabbitMQ  

## 3. Worker - MT
- process  
- call the API  
- insert a record into the MT table  
- dn_status and dn_details remain pending  

## 4. API - DN
- process and enqueue into RabbitMQ  

## 5. Worker - DN
- process and update the MT table by mt_ref_id  

## 6. Worker - Renewal
- read renewal_plan and subscription  
- generate MT data into RabbitMQ  
- set renewal_job status to queued  
- once the MT worker processes it, update the job to done  

## 7. Subscription Page
- input MSISDN  
- call subscription API  
- show success/fail message on the same or next page  
- hide MSISDN input after submission  

## 8. Emulator Page
- list all mt_ref_id values  
- allow clicking a button to trigger DN  
