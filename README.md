# 📔 Daily-Istory - Shaxsiy Kundalik va Rejalashtirish Web Sayti

## 📌 Loyiha haqida

Daily-Istory bu PHP va MySQL yordamida yaratilgan shaxsiy kundalik va rejalashtirish web ilovasi hisoblanadi.  
Tizim foydalanuvchilarga kunlik rejalar tuzish, ularni boshqarish, bajarilgan yoki bajarilmaganligini kuzatish hamda o‘tgan kunlar tarixini ko‘rish imkonini beradi.

Administrator esa foydalanuvchilarni boshqarishi, akkauntlarni `block/unblock` qilishi va foydalanuvchi ma’lumotlarini nazorat qilishi mumkin.

---

# ✨ Asosiy imkoniyatlar

## 👤 Foydalanuvchi qismi

- Ro‘yxatdan o‘tish
- Tizimga kirish
- Logout
- Profilni tahrirlash
- Parolni o‘zgartirish
- Username ko‘rish
- Kunlik reja qo‘shish
- Rejani tahrirlash
- Rejani o‘chirish
- Rejani ko‘rish
- Rejani statusga o‘tkazish
- Rejalarni qidirish
- O‘tgan kunlar tarixini ko‘rish
- Real vaqtli qidiruv tizimi

---

---

# ❌ Missed tizimi

Agar foydalanuvchi rejasini bajarmasa:

- tizim izoh so‘raydi
- sabab database’da saqlanadi

---

# 🔒 Vaqt himoyasi

O‘tib ketgan rejalar:

- tahrir qilib bo‘lmaydi
- vaqt bo‘yicha bloklanadi

Tizim:

```text
Asia/Tashkent
```

vaqt zonasi asosida ishlaydi.

---

# 📚 History tizimi

History sahifasida:

- kunlar bo‘yicha katalog mavjud
- kerakli kun tanlanadi
- o‘sha kundagi rejalar ko‘rinadi

---

# 🔎 Live Search tizimi

## 👤 Foydalanuvchi

- rejalarni real vaqtda qidira oladi

## 👑 Admin

- foydalanuvchilarni real vaqtda qidira oladi

Page refreshsiz ishlaydi.

---

# 👑 Admin Panel

Administrator quyidagilarni boshqarishi mumkin:

- foydalanuvchilarni ko‘rish
- foydalanuvchilarni qidirish
- foydalanuvchi profilini ko‘rish
- username o‘zgartirish
- akkauntni block qilish
- akkauntni unblock qilish

---

# 📊 Dashboard imkoniyatlari

## 👤 Foydalanuvchi dashboardi

- kunlik rejalar
- statuslar
- vaqt
- tezkor boshqaruv tugmalari

---

# 🧱 Texnologiyalar

## Backend

- PHP 7.4
- MySQL
- PDO

## Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

---

# 📂 Loyiha strukturasi

```text
daily-istory/
│
├── admin/
├── auth/
├── config/
├── includes/
├── plans/
│
├── dashboard.php
├── history.php
├── index.php
├── profile.php
```

---

# 🗄️ Database jadvallari

## users

Foydalanuvchilar ma’lumotlari

## plans

Kunlik rejalar ma’lumotlari

---

# 🚀 O‘rnatish

## 1. Loyihani clone qilish

```bash
git clone https://github.com/sanatbekcoder/daily-istory.git
```

---

## 2. Database yaratish

phpMyAdmin orqali:

```sql
CREATE DATABASE daily_istory;
```

---

## 3. SQL faylni import qilish

Berilgan `.sql` faylni import qiling.

---

## 4. Database ulanishini sozlash

`config/database.php`

```php
<?php

$pdo = new PDO(

    "mysql:host=localhost;dbname=daily_istory",

    "root",

    ""

);
```

---

---

# 🌐 Hosting talablari

- PHP 7.4+
- MySQL 5.7+
- Apache yoki Nginx
- PDO extension

---

# 🔒 Xavfsizlik

Loyihada quyidagilar ishlatilgan:

- `password_hash()`
- `password_verify()`
- PDO prepared statements
- Session himoyasi
- Admin middleware
- Username unique check
- XSS himoyasi (`htmlspecialchars`)

---

# 📸 Demo imkoniyatlari

- Test foydalanuvchilar
- Test rejalar
- Admin panel
- Real vaqtli qidiruv
- Status tizimi

---

# 📌 Muallif

## Sanatbekcoder 🚀

GitHub:  
https://github.com/sanatbekcoder

---
