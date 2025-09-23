### 🔹 *Frontend*
- ⚡ *Progressive Web App (PWA) support*
- 🎨 *Modern & responsive design*
- 🛒 *Shopping cart, wishlist, and order tracking*
- 🔎 *SEO-friendly URLs & metadata*
- 💳 *Integrated PayPal payment gateway*
- 📢 *Social login (Google, Facebook, Github)*
- 💬 *Multi-level comments & reviews*

### 🔹 *Admin Dashboard*
- 🎛 *Role management*
- 📊 *Advanced analytics & reporting*
- 🛍 *Product & order management*
- 🔔 *Real-time notifications & messaging*
- 🏷 *Coupon & discount system*
- 📰 *Blog & category management*
- 📸 *Media & banner manager*

### 🔹 *User Dashboard*
- 📦 *Order history & tracking*
- 💬 *Review & comment system*
- 🔧 *Profile customization*

---

## 🛠 Installation Guide

### 🔹 *Step 1: Clone the Repository*
sh
git clone https://github.com/SanthoshITOI/benny_cards.git
cd benny_cards

### 🔹 *Step 2: Install Dependencies*
sh
composer install
npm install


### 🔹 *Step 3: Environment Setup*
sh
cp .env.example .env
php artisan key:generate

Update .env with database credentials.

### 🔹 *Step 4: Database Configuration*
sh
php artisan migrate --seed

Import database/e-shop.sql into your database manually (if needed).

### 🔹 *Step 5: Setup Storage*
sh
php artisan storage:link


### 🔹 *Step 6: Run the Application*
sh
php artisan serve

🔗 Open http://localhost:8000

### *Admin Login Credentials:*
📧 *Email:* admin@gmail.com  
🔑 *Password:* 1111

---

## 📜 License
🔹 This project is *MIT Licensed* – Feel free to use & modify!

⭐ *If you find this project helpful, don't forget to star it!* ⭐
