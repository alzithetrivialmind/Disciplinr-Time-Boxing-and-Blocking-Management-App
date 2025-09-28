# 🚀 Tutorial Lengkap Deploy Time Boxing App ke Vercel

## 📋 Prasyarat

1. **Akun GitHub** - [github.com](https://github.com) (gratis)
2. **Akun Vercel** - [vercel.com](https://vercel.com) (gratis)
3. **Database eksternal** - PlanetScale, Neon, Supabase, atau Railway (gratis tier)
4. **Git terinstall** di komputer Anda
5. **Node.js** terinstall (untuk Vercel CLI)

---

## 🗄️ Step 1: Setup Database Production

### Opsi A: PlanetScale (MySQL) - **RECOMMENDED**
1. **Buat akun PlanetScale**
   - Buka [planetscale.com](https://planetscale.com)
   - Klik "Sign up" dan daftar dengan GitHub
   - Verifikasi email

2. **Buat database baru**
   - Klik "Create database"
   - Nama: `timebox-app`
   - Region: pilih yang terdekat (Asia Pacific)
   - Klik "Create database"

3. **Dapatkan connection credentials**
   - Klik database yang baru dibuat
   - Klik "Connect" → "General"
   - Copy informasi connection:
     - Host
     - Username
     - Password
     - Database name

### Opsi B: Neon (PostgreSQL)
1. **Buat akun Neon**
   - Buka [neon.tech](https://neon.tech)
   - Klik "Sign up" dan daftar dengan GitHub

2. **Buat database baru**
   - Klik "Create project"
   - Nama: `timebox-app`
   - Region: pilih yang terdekat
   - Klik "Create project"

3. **Dapatkan connection string**
   - Di dashboard, copy connection string
   - Format: `postgresql://username:password@host/database`

---

## 📤 Step 2: Push ke GitHub

### 2.1: Initialize Git Repository
```bash
# Di folder project Anda
git init

# Add semua file
git add .

# Commit pertama
git commit -m "Initial commit: Time Boxing App"
```

### 2.2: Buat Repository di GitHub
1. **Login ke GitHub**
   - Buka [github.com](https://github.com)
   - Login dengan akun Anda

2. **Buat repository baru**
   - Klik tombol "+" di kanan atas
   - Pilih "New repository"
   - Repository name: `timebox-app`
   - Description: "Time Boxing & Time Blocking Management App"
   - Pilih "Public" (gratis)
   - **JANGAN** centang "Add a README file"
   - Klik "Create repository"

### 2.3: Connect Local ke GitHub
```bash
# Add remote origin (ganti username dengan GitHub username Anda)
git remote add origin https://github.com/USERNAME/timebox-app.git

# Push ke GitHub
git push -u origin main
```

**Catatan**: Jika error "main branch doesn't exist", gunakan:
```bash
git branch -M main
git push -u origin main
```

### 2.4: Verify di GitHub
- Buka repository di GitHub
- Pastikan semua file sudah ter-upload
- File penting yang harus ada:
  - `composer.json`
  - `vercel.json`
  - `api/index.php`
  - `app/`, `config/`, `database/`, `resources/`, `routes/`

---

## 🚀 Step 3: Deploy ke Vercel

### 3.1: Login ke Vercel
1. **Buka Vercel Dashboard**
   - Buka [vercel.com](https://vercel.com)
   - Klik "Sign up" atau "Login"

2. **Login dengan GitHub**
   - Pilih "Continue with GitHub"
   - Authorize Vercel untuk akses GitHub repositories

### 3.2: Import Project
1. **Klik "New Project"**
   - Di dashboard Vercel
   - Klik tombol "New Project"

2. **Pilih Repository**
   - Cari dan pilih `timebox-app` dari daftar repository
   - Klik "Import"

### 3.3: Configure Project Settings
1. **Project Name**
   - Nama: `timebox-app` (atau sesuai keinginan)
   - Framework Preset: **Other**
   - Root Directory: `./` (default)

2. **Build Settings**
   - Build Command: (kosongkan)
   - Output Directory: (kosongkan)
   - Install Command: (kosongkan)

3. **Klik "Deploy"**
   - Tunggu proses deploy selesai (2-3 menit)

---

## ⚙️ Step 4: Setup Environment Variables

### 4.1: Generate APP_KEY
```bash
# Di komputer lokal, generate key
php artisan key:generate --show
# Copy output yang muncul (format: base64:...)
```

### 4.2: Set Environment Variables di Vercel
1. **Buka Project Settings**
   - Di Vercel dashboard, klik project `timebox-app`
   - Klik tab "Settings"

2. **Environment Variables**
   - Klik "Environment Variables"
   - Tambahkan variables berikut:

```
APP_NAME=Time Boxing App
APP_ENV=production
APP_KEY=base64:PASTE_KEY_DARI_STEP_4.1
APP_DEBUG=false
APP_URL=https://timebox-app.vercel.app

DB_CONNECTION=mysql
DB_HOST=PASTE_HOST_DARI_PLANETSCALE
DB_PORT=3306
DB_DATABASE=PASTE_DATABASE_NAME
DB_USERNAME=PASTE_USERNAME
DB_PASSWORD=PASTE_PASSWORD
```

3. **Save Variables**
   - Klik "Save" untuk setiap variable
   - Pastikan semua variables tersimpan

### 4.3: Redeploy dengan Environment Variables
1. **Trigger Redeploy**
   - Klik tab "Deployments"
   - Klik "Redeploy" pada deployment terbaru
   - Atau push commit baru ke GitHub

---

## 🗄️ Step 5: Setup Database

### 5.1: Install Vercel CLI
```bash
# Install Vercel CLI globally
npm install -g vercel

# Verify installation
vercel --version
```

### 5.2: Login dan Link Project
```bash
# Login ke Vercel
vercel login

# Link ke project (pilih project yang benar)
vercel link
```

### 5.3: Run Database Migration
```bash
# Pull environment variables
vercel env pull .env.production

# Run migration (akan dijalankan di Vercel)
vercel env add DB_CONNECTION mysql
vercel env add DB_HOST your-host
vercel env add DB_PORT 3306
vercel env add DB_DATABASE your-database
vercel env add DB_USERNAME your-username
vercel env add DB_PASSWORD your-password

# Deploy dengan environment variables
vercel --prod
```

**Alternatif**: Gunakan Vercel Dashboard untuk set environment variables (lebih mudah).

---

## ✅ Step 6: Test Aplikasi

### 6.1: Buka Aplikasi
1. **Dapatkan URL aplikasi**
   - Di Vercel dashboard, klik project
   - Copy URL dari "Domains" (format: `https://timebox-app.vercel.app`)

2. **Test di browser**
   - Buka URL aplikasi
   - Pastikan halaman load tanpa error

### 6.2: Test Fitur Utama
1. **Test Checklist Form**
   - Isi beberapa pertanyaan
   - Klik "Simpan Checklist"
   - Pastikan berhasil tersimpan

2. **Test Analytics**
   - Lihat history cards
   - Pastikan progress bars muncul
   - Test responsive design (mobile)

3. **Test API Endpoints**
   - Buka `https://your-app.vercel.app/api/history`
   - Pastikan return JSON data
   - Test endpoint lainnya

### 6.3: Verify Database
1. **Check di PlanetScale/Neon**
   - Login ke database provider
   - Lihat tabel `checklists` dan `checklist_items`
   - Pastikan data tersimpan

---

## 🔧 Step 7: Troubleshooting

### Error: "Function timeout"
**Solusi:**
- Vercel Hobby plan timeout 10 detik
- Optimize queries di controller
- Gunakan caching untuk data yang tidak sering berubah

### Error: "Database connection failed"
**Solusi:**
- Check environment variables di Vercel
- Pastikan database credentials benar
- Test connection dari database provider

### Error: "File not found"
**Solusi:**
- Pastikan `api/index.php` ada
- Check `vercel.json` configuration
- Verify file structure di GitHub

### Error: "Session not working"
**Solusi:**
- Set `SESSION_DRIVER=database` di environment variables
- Buat tabel sessions di database
- Run migration untuk sessions

---

## 📊 Step 8: Monitoring & Maintenance

### 8.1: Vercel Analytics
- Monitor performance di Vercel dashboard
- Check function execution time
- Monitor error rates

### 8.2: Database Monitoring
- Monitor query performance di PlanetScale/Neon
- Check connection limits
- Monitor storage usage

### 8.3: Regular Updates
- Update dependencies secara berkala
- Monitor security updates
- Backup database secara regular

---

## 🎉 Success!

Jika semua step berhasil, Anda sekarang memiliki:
- ✅ Aplikasi Time Boxing yang live di Vercel
- ✅ Database production yang berfungsi
- ✅ Analytics dan scoring yang bekerja
- ✅ UI yang responsive dan aesthetic
- ✅ API endpoints yang berfungsi

**URL Aplikasi**: `https://your-app.vercel.app`

**Next Steps**:
- Share aplikasi dengan tim
- Monitor usage dan performance
- Collect feedback untuk improvement
- Consider upgrade ke Vercel Pro untuk scaling
