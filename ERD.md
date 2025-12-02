# Entity Relationship Diagram (ERD)
## Loundry'sS - Smart Laundry Service & Machine Rental System

---

## 📄 TEKS UNTUK SLIDE PRESENTASI

### **Versi 1: Ringkas & Professional**

```
ARSITEKTUR DATABASE SISTEM

Loundry'sS - Smart Laundry Service & Machine Rental System

🗂️ Struktur Database:
• 17 Tabel Terintegrasi
• 15 Relasi Foreign Key
• 10 Tabel Utama + 7 Tabel Sistem Laravel

📊 Entitas Utama:
• Users - Manajemen pengguna (Customer, Admin, Branch Admin)
• Orders - Pemrosesan pesanan layanan laundry
• Machines - Sistem rental mesin cuci self-service
• Payments & Invoices - Integrasi pembayaran Midtrans
• Reviews - Rating dan feedback pelanggan
• Promos - Sistem diskon dan promosi
• Rentals - Tracking penggunaan mesin

✅ Fitur Database:
• Multi-role user management
• Real-time machine tracking
• Automated invoice generation
• Promo code system
• Gamification dengan poin
```

---

### **Versi 2: Lebih Detail**

```
DATABASE DESIGN - LOUNDRY'SS SYSTEM

📌 Overview
Sistem database terintegrasi untuk layanan laundry online, 
rental mesin cuci self-service, dan manajemen multi-cabang.

🔗 Relasi Utama:
├─ Users → Orders (One-to-Many)
├─ Users → Machines (Branch Admin)
├─ Orders → Invoices → Payments
├─ Machines → Rentals
└─ Orders → Reviews

💡 Keunggulan Arsitektur:
✓ Normalisasi database optimal
✓ Referential integrity dengan foreign keys
✓ Scalable untuk multi-branch
✓ Support online & offline transactions
✓ Audit trail dengan timestamps
```

---

### **Versi 3: Minimalis (untuk slide dengan ERD besar)**

```
ENTITY RELATIONSHIP DIAGRAM
Loundry'sS Database Architecture

📊 17 Tables | 15 Relationships

Core Modules:
• User Management
• Order Processing
• Machine Rental System
• Payment Integration
• Review & Rating System

Designed for scalability and multi-branch operations
```

---

### **Versi 4: Storytelling Style**

```
DARI DATA MENJADI SOLUSI

Loundry'sS Database Design

🎯 Masalah:
Bagaimana mengelola layanan laundry online, rental mesin, 
multi-cabang, dan pembayaran digital dalam satu sistem?

💡 Solusi:
Arsitektur database terintegrasi dengan:
• 17 tabel yang saling terhubung
• 15 relasi untuk menjaga integritas data
• Support multi-role (Customer, Admin, Branch Admin)
• Real-time tracking order dan mesin
• Otomasi invoice dan pembayaran

📈 Hasil:
Sistem yang efisien, scalable, dan mudah di-maintain
```

---

## 🎨 Tips Desain Slide:

### **Layout yang Disarankan:**
1. **Judul**: Di bagian atas (bold, ukuran besar)
2. **ERD Diagram**: Sisi kanan (60-70% lebar slide)
3. **Teks Penjelasan**: Sisi kiri (30-40% lebar slide)
4. **Footer**: Nama project + logo

### **Warna yang Cocok:**
- **Background**: Putih atau Light Gray (#F5F5F5)
- **Accent**: Blue (#2563EB) untuk profesional
- **Highlight**: Orange/Yellow (#F59E0B) untuk poin penting

### **Font Recommendation:**
- **Heading**: Poppins Bold / Montserrat Bold
- **Body**: Inter Regular / Open Sans

---

**Copy paste kode di bawah ini ke dbdiagram.io**

```dbml
// Loundry'sS - Smart Laundry Service & Machine Rental System
// ERD Database Schema

Table users {
  id bigint [pk, increment]
  name varchar [not null]
  email varchar [unique, not null]
  password varchar [not null]
  role varchar [not null, default: 'customer', note: 'customer, admin, branch_admin']
  address varchar [null]
  email_verified_at varchar [null]
  remember_token varchar [null]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel pengguna sistem dengan role: customer, admin, branch_admin'
}

Table machines {
  id bigint [pk, increment]
  machine_id varchar [unique, not null]
  location varchar [not null]
  status varchar [not null, default: 'available', note: 'available, in_use, unpaid, pending']
  availability varchar [not null, default: 'available', note: 'available, unavailable']
  payment_status varchar [not null, default: 'unpaid', note: '-, paid, unpaid']
  branch_admin_id bigint [null, ref: > users.id]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel mesin laundry untuk sistem rental'
}

Table orders {
  id bigint [pk, increment]
  order_id varchar [unique, not null]
  user_id bigint [not null, ref: > users.id]
  order_type varchar [not null, default: 'online']
  branch_admin_id varchar [null]
  service_type varchar [not null]
  weight float [null]
  price decimal(10,2) [null]
  booking_fee decimal(10,2) [null]
  pickup_address varchar [not null]
  pickup_time datetime [not null]
  status varchar [not null, default: 'pending', note: 'pending, completed, cancelled, denied, expired, challenge, settlement, failed, success, pickup_scheduled, processing, ready_for_pickup']
  approximate_price decimal(10,2) [null]
  final_payment_method varchar [null]
  payment_status varchar [not null, default: 'pending', note: 'pending, paid, failed']
  promo_code varchar [null]
  snap_token varchar [null]
  final_payment_snap_token varchar [null]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel pesanan layanan laundry'
}

Table service_packages {
  id bigint [pk, increment]
  name varchar [not null]
  description text [null]
  price_per_kg decimal(8,2) [not null]
  status varchar [default: 'active', note: 'active, inactive']
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel paket layanan laundry'
}

Table invoices {
  id bigint [pk, increment]
  order_id bigint [not null, ref: > orders.id]
  total decimal(10,2) [not null]
  status varchar [not null, default: 'unpaid', note: 'unpaid, paid']
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel invoice pembayaran'
}

Table payments {
  id bigint [pk, increment]
  invoice_id bigint [null, ref: > invoices.id]
  order_id bigint [null, ref: > orders.id]
  amount decimal(10,2) [not null]
  method varchar [not null, default: 'cash', note: 'cash, credit, debit, ewallet']
  status varchar [not null, default: 'pending', note: 'pending, completed, failed']
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel pembayaran'
}

Table promos {
  id bigint [pk, increment]
  code varchar [unique, not null]
  discount_percentage decimal(5,2) [not null, default: 0]
  valid_until date [not null]
  is_active boolean [not null, default: true]
  branch_admin_id bigint [null, ref: > users.id]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel kode promosi dan diskon'
}

Table reviews {
  id bigint [pk, increment]
  user_id bigint [not null, ref: > users.id]
  order_id bigint [not null, ref: > orders.id]
  branch_id varchar [null]
  rating tinyint [not null]
  comment text [null]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel ulasan dan rating pelanggan'
}

Table reports {
  id bigint [pk, increment]
  type varchar [not null]
  data json [null]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel laporan sistem'
}

Table rentals {
  id bigint [pk, increment]
  user_id bigint [not null, ref: > users.id]
  machine_id bigint [not null, ref: > machines.id]
  rental_time datetime [not null]
  price decimal(10,2) [not null]
  status varchar [not null, default: 'unpaid', note: 'unpaid, in_use, completed, cancelled']
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel rental/sewa mesin laundry'
}

Table games {
  id bigint [pk, increment]
  user_id bigint [null, ref: > users.id]
  score int [not null, default: 0]
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel skor game pengguna'
}

// Laravel System Tables

Table password_reset_tokens {
  email varchar [pk]
  token varchar [not null]
  created_at timestamp [null]
  
  Note: 'Tabel token reset password'
}

Table sessions {
  id varchar [pk]
  user_id bigint [null, ref: > users.id]
  ip_address varchar(45) [null]
  user_agent text [null]
  payload longtext [not null]
  last_activity int [not null]
  
  Note: 'Tabel sesi pengguna'
}

Table cache {
  key varchar [pk]
  value text [not null]
  expiration int [not null]
  
  Note: 'Tabel cache Laravel'
}

Table cache_locks {
  key varchar [pk]
  owner varchar [not null]
  expiration int [not null]
  
  Note: 'Tabel cache locks'
}

Table jobs {
  id bigint [pk, increment]
  queue varchar [not null]
  payload longtext [not null]
  attempts tinyint [not null]
  reserved_at int [null]
  available_at int [not null]
  created_at int [not null]
  
  Note: 'Tabel antrian pekerjaan'
}

Table job_batches {
  id varchar [pk]
  name varchar [not null]
  total_jobs int [not null]
  pending_jobs int [not null]
  failed_jobs int [not null]
  failed_job_ids longtext [not null]
  options text [null]
  cancelled_at int [null]
  created_at int [not null]
  finished_at int [null]
  
  Note: 'Tabel batch pekerjaan'
}

Table failed_jobs {
  id bigint [pk, increment]
  uuid varchar [unique, not null]
  connection text [not null]
  queue text [not null]
  payload longtext [not null]
  exception longtext [not null]
  failed_at timestamp [default: `CURRENT_TIMESTAMP`]
  
  Note: 'Tabel log pekerjaan yang gagal'
}
```

---

## 📋 Penjelasan Relasi Database

### **1. USERS** (Tabel Pengguna)
- **Role**: customer, admin, branch_admin
- **Relasi**:
  - ✅ One User → Many Orders
  - ✅ One User → Many Rentals
  - ✅ One User → Many Reviews
  - ✅ One User → Many Games
  - ✅ One Branch Admin → Many Machines
  - ✅ One Branch Admin → Many Promos

### **2. MACHINES** (Tabel Mesin Laundry)
- **Atribut**: machine_id, location, status, availability
- **Relasi**:
  - ✅ One Machine → Many Rentals
  - ✅ Many Machines → One Branch Admin

### **3. ORDERS** (Tabel Pesanan)
- **Jenis**: online/offline
- **Status**: Multiple stages dari pending hingga completed
- **Relasi**:
  - ✅ Many Orders → One User
  - ✅ One Order → Many Invoices
  - ✅ One Order → Many Reviews
  - ✅ One Order → Many Payments

### **4. SERVICE_PACKAGES** (Paket Layanan)
- Paket layanan dengan harga per kilogram

### **5. INVOICES** (Tabel Invoice)
- **Relasi**:
  - ✅ Many Invoices → One Order
  - ✅ One Invoice → Many Payments

### **6. PAYMENTS** (Tabel Pembayaran)
- **Metode**: cash, credit, debit, ewallet
- **Relasi**:
  - ✅ Many Payments → One Invoice
  - ✅ Many Payments → One Order

### **7. PROMOS** (Tabel Promosi)
- Kode promo dengan diskon persentase
- **Relasi**:
  - ✅ Many Promos → One Branch Admin

### **8. REVIEWS** (Tabel Ulasan)
- Rating dan komentar pelanggan
- **Relasi**:
  - ✅ Many Reviews → One User
  - ✅ Many Reviews → One Order

### **9. RENTALS** (Tabel Sewa Mesin)
- **Relasi**:
  - ✅ Many Rentals → One User
  - ✅ Many Rentals → One Machine

### **10. GAMES** (Tabel Game)
- Sistem poin/skor untuk gamifikasi
- **Relasi**:
  - ✅ Many Games → One User

---

## 🎯 Cara Menggunakan:

1. **Buka** [dbdiagram.io](https://dbdiagram.io)
2. **Copy** semua kode di dalam blok code DBML di atas
3. **Paste** ke editor dbdiagram.io
4. **Klik** "Import" atau langsung paste di editor
5. **Diagram ERD** akan otomatis ter-generate! ✨

---

## 💡 Fitur DBML yang Digunakan:

- `[pk]` - Primary Key
- `[pk, increment]` - Auto-increment Primary Key
- `[unique]` - Unique constraint
- `[not null]` - Not null constraint
- `[null]` - Nullable field
- `[default: value]` - Default value
- `[ref: > table.column]` - Foreign key relationship
- `[note: 'text']` - Column notes
- `Note: 'text'` - Table notes

---

**Project**: Loundry'sS - Smart Laundry Service & Machine Rental System  
**Total Tables**: 17 (10 main tables + 7 Laravel system tables)  
**Total Relationships**: 15 foreign key relationships
