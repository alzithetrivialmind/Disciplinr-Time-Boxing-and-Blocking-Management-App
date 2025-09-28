# Time Boxing & Time Blocking Management App

A simple Laravel application for Time Boxing and Time Blocking checklist with analytics and Vercel deployment.

## Features

- ✅ Weekly checklist for Time Blocking & Time Boxing
- 📊 Analytics and automatic scoring
- 📈 Trend analysis and frequent failure report
- 🎨 Aesthetic UI with Bootstrap
- 🚀 Deploy to Vercel (free)

## Local Setup

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Setup database:**
   ```bash
   php artisan migrate
   ```

4. **Run application:**
   ```bash
   php artisan serve
   ```

## Deploy to Vercel

1. **Push to GitHub:**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin <your-github-repo>
   git push -u origin main
   ```

2. **Deploy to Vercel:**
   - Connect GitHub repo to Vercel
   - Set environment variables in Vercel dashboard:
     - `APP_KEY`: Generate with `php artisan key:generate --show`
     - `DB_CONNECTION`: `sqlite` (for demo) or `mysql`/`pgsql` (for production)
     - `DB_DATABASE`: Path to database file or connection string

3. **Production Database:**
   - For production, use external database (PlanetScale, Neon, Supabase)
   - Update `DB_CONNECTION` and credentials in Vercel

## Application Structure

```
├── app/
│   ├── Http/Controllers/ChecklistController.php
│   └── Models/
│       ├── Checklist.php
│       └── ChecklistItem.php
├── config/checklist.php          # Question list
├── database/migrations/          # Database schema
├── resources/views/               # Blade templates
├── routes/
│   ├── web.php                  # Web routes
│   └── api.php                  # API routes
├── api/index.php                # Vercel entry point
├── vercel.json                  # Vercel configuration
└── public/index.php             # Laravel entry point
```

## API Endpoints

- `GET /api/history` - History checklist
- `GET /api/trends` - Performance trends
- `GET /api/frequent-failures` - Frequent failure report
- `GET /api/category-analysis` - Category analysis

## Indicators & Analytics

1. **Overall Score**: Overall compliance percentage
2. **Category Scores**: Score per category (Time Blocking, Time Boxing, Collaboration)
3. **Trends**: Weekly performance charts
4. **Frequent Failures**: Questions frequently answered "No"
5. **Color Coding**: 
   - 🟢 Green: ≥80% (Excellent)
   - 🟡 Yellow: 50-79% (Good)
   - 🔴 Red: <50% (Needs Improvement)

## Vercel Deployment Notes

- Vercel uses serverless functions with limited timeout
- Database must be external for production
- File storage is ephemeral (use S3 for file uploads)
- Not suitable for background jobs/queues
