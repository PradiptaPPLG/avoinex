cara composer install di bat
/d/xampp_new/php/composer.bat install

✅ Alur yang BENAR

1️⃣ Mulai dari develop
git checkout develop
git pull origin develop

Kenapa?
Supaya branch baru kamu dibuat dari versi terbaru.

2️⃣ Buat branch baru untuk fix
git checkout -b fix/booking-notfound

Sekarang kamu kerja di branch itu.
Bukan di develop.

3️⃣ Fixing fixing 🔧

Edit file.
Test.
Pastikan error hilang.



4️⃣ Commit di branch itu
git add .
git commit -m "Fix booking not found error in BookingController"
5️⃣ Push branch fix ke GitHub
git push origin fix/booking-notfound

Sekarang branch fix ada di GitHub.

🔥 Lalu gimana masuk ke develop?

Ada 2 cara.

🚀 Cara Simple (langsung merge lokal)
git checkout develop
git merge fix/booking-notfound
git push origin develop

Selesai.

🚀 Cara Profesional (Recommended)

Push branch fix

Buka GitHub

Create Pull Request

Merge ke develop

Kenapa ini bagus?
Karena:

Bisa review dulu

Bisa lihat perubahan

Lebih profesional

Aman kalau kerja tim

📌 Jadi Jawaban Pertanyaan Kamu:

fixing fixing terus?? ke develop lagi push nya?

Bukan langsung push ke develop.

Flow yang benar:

develop
   ↓
buat branch fix
   ↓
kerja di branch fix
   ↓
push branch fix
   ↓
merge ke develop
   ↓
push develop
🎯 Analogi Biar Mudah

Develop = dapur utama 🍳
Feature branch = meja kecil buat masak satu menu

Kalau masakan sudah jadi → baru bawa ke dapur utama.

CARA AKSES ADMIN: clik 7 kali cepat + 123 + enter
avoinexadmin@gmailcom > avoinexadmin