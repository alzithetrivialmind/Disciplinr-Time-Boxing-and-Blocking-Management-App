# 🤖 Prompt Siap-Pakai untuk Cursor AI

## Prompt Lengkap untuk Cursor

```
Saya ingin membuat aplikasi Laravel untuk Time Blocking & Time Boxing checklist dengan deploy ke Vercel. Berikut spesifikasi lengkap:

### 1. FITUR UTAMA
- Checklist mingguan dengan pertanyaan Time Blocking & Time Boxing
- Scoring otomatis dengan indikator warna (hijau ≥80%, kuning 50-79%, merah <50%)
- Analytics: trend analysis, frequent failure report, category analysis
- UI aesthetic seperti Gumroad (minimalist, clean, modern)
- API endpoints untuk data analytics

### 2. STRUKTUR DATABASE
- Table `checklists`: id, week_label, user_id, total_questions, yes_count, timestamps
- Table `checklist_items`: id, checklist_id, category, question, answer, timestamps
- Relasi: Checklist hasMany ChecklistItem

### 3. PERTANYAAN CHECKLIST (config/checklist.php)
```php
return [
    'Time Blocking' => [
        'Apakah semua aktivitas penting masuk ke kalender?',
        'Apakah setiap blok hanya berisi 1 fokus utama?',
        'Apakah ada ruang buffer antar blok?',
        'Apakah blok dijalankan sesuai jadwal?',
        'Apakah aktivitas prioritas selalu ada bloknya?',
    ],
    'Time Boxing' => [
        'Apakah setiap tugas punya batas waktu (box)?',
        'Apakah kamu berhenti/evaluasi ketika waktu box habis?',
        'Apakah tugas selesai di dalam durasi box?',
        'Apakah ada review setelah box selesai?',
        'Apakah box membantu fokus & mengurangi penundaan?',
    ],
    'Kolaborasi' => [
        'Apakah blok dipecah jadi box lebih kecil?',
        'Apakah tugas jarang meluber ke blok berikutnya?',
        'Apakah ritme kerja seimbang (fokus → break → fokus lagi)?',
    ],
];
```

### 4. INDIKATOR & ANALYTICS
- Overall Score: (yes_count / total_questions) * 100
- Category Scores: Score per kategori dengan breakdown
- Trends: Grafik performa mingguan (Chart.js)
- Frequent Failures: Top 5 pertanyaan paling sering dijawab "No"
- Color Coding: success/warning/danger berdasarkan threshold

### 5. CONTROLLER LOGIC
- ChecklistController dengan methods: index(), store(), history(), trends(), frequentFailures(), categoryAnalysis()
- Week label menggunakan ISO format: Carbon::now()->format('o-\WW')
- Scoring logic di model dengan accessor getScoreAttribute()
- Category analysis dengan getCategoryScores()

### 6. UI/UX REQUIREMENTS
- Bootstrap 5 dengan custom CSS variables
- Color scheme: primary #6366f1, success #10b981, warning #f59e0b, danger #ef4444
- Cards dengan shadow dan hover effects
- Progress bars dengan color coding
- Responsive design untuk mobile
- Icons dari Bootstrap Icons

### 7. API ENDPOINTS
- GET /api/history - History checklist
- GET /api/trends - Performance trends
- GET /api/frequent-failures - Frequent failure report
- GET /api/category-analysis - Category analysis

### 8. VERCEL DEPLOYMENT
- File api/index.php untuk entry point
- vercel.json dengan PHP runtime configuration
- Environment variables untuk database
- .vercelignore untuk exclude files

### 9. FILE STRUCTURE YANG DIBUTUHKAN
```
├── app/
│   ├── Http/Controllers/ChecklistController.php
│   ├── Models/Checklist.php
│   ├── Models/ChecklistItem.php
│   └── Providers/AppServiceProvider.php
├── config/
│   ├── app.php
│   ├── database.php
│   ├── checklist.php
│   ├── cache.php
│   ├── session.php
│   ├── view.php
│   └── logging.php
├── database/migrations/
│   ├── create_checklists_table.php
│   └── create_checklist_items_table.php
├── resources/views/
│   ├── layouts/app.blade.php
│   └── checklist/index.blade.php
├── routes/
│   ├── web.php
│   └── api.php
├── api/index.php
├── vercel.json
├── composer.json
├── package.json
└── README.md
```

### 10. IMPLEMENTASI STEP-BY-STEP
1. Buat Laravel project structure
2. Setup database migrations dengan schema yang benar
3. Buat models dengan relasi dan accessor methods
4. Buat controller dengan semua methods yang diperlukan
5. Buat config file untuk pertanyaan checklist
6. Buat Blade templates dengan UI yang aesthetic
7. Setup routing untuk web dan API
8. Buat file untuk Vercel deployment
9. Test aplikasi secara lokal
10. Setup deployment ke Vercel

### 11. TECHNICAL REQUIREMENTS
- Laravel 10+ dengan PHP 8.1+
- Bootstrap 5 untuk UI
- Chart.js untuk analytics
- SQLite untuk development, MySQL/PostgreSQL untuk production
- Vercel PHP runtime untuk deployment
- Environment variables untuk configuration

### 12. TESTING CHECKLIST
- [ ] Form checklist berfungsi
- [ ] Scoring calculation benar
- [ ] Analytics data akurat
- [ ] UI responsive dan aesthetic
- [ ] API endpoints return data yang benar
- [ ] Deploy ke Vercel berhasil
- [ ] Database connection di production

Tolong buat aplikasi Laravel lengkap sesuai spesifikasi di atas. Pastikan semua fitur berfungsi dan siap untuk deploy ke Vercel.
```

## Cara Menggunakan Prompt

1. **Copy prompt di atas** ke Cursor AI
2. **Paste di chat** dengan Cursor
3. **Cursor akan generate** semua file yang diperlukan
4. **Follow instructions** untuk setup dan deploy
5. **Test aplikasi** sebelum deploy ke production

## Tips untuk Cursor

- **Be specific** dengan requirements
- **Mention file structure** yang jelas
- **Include code examples** untuk logic yang kompleks
- **Specify UI/UX requirements** dengan detail
- **Mention deployment requirements** untuk Vercel

## Troubleshooting dengan Cursor

Jika ada error:
1. **Check file structure** sesuai requirements
2. **Verify database schema** dengan migrations
3. **Test API endpoints** dengan Postman/curl
4. **Check Vercel configuration** untuk deployment
5. **Verify environment variables** di production

## Next Steps Setelah Cursor Generate

1. **Review generated code** untuk memastikan sesuai requirements
2. **Test locally** dengan `php artisan serve`
3. **Setup database** dengan `php artisan migrate`
4. **Test all features** sebelum deploy
5. **Deploy to Vercel** dengan environment variables yang benar
6. **Monitor performance** setelah deploy
