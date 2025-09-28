<?php
/**
 * Simple test setup for Time Boxing application
 * Run with: php test-setup.php
 */

echo "🚀 Testing Time Boxing App Setup...\n\n";

// Test 1: Check if required files exist
echo "📁 Checking required files...\n";
$requiredFiles = [
    'composer.json',
    'config/app.php',
    'config/database.php',
    'config/checklist.php',
    'app/Models/Checklist.php',
    'app/Models/ChecklistItem.php',
    'app/Http/Controllers/ChecklistController.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/checklist/index.blade.php',
    'routes/web.php',
    'routes/api.php',
    'api/index.php',
    'vercel.json',
    'database/migrations/2024_01_01_000001_create_checklists_table.php',
    'database/migrations/2024_01_01_000002_create_checklist_items_table.php'
];

$missingFiles = [];
foreach ($requiredFiles as $file) {
    if (!file_exists($file)) {
        $missingFiles[] = $file;
    } else {
        echo "✅ $file\n";
    }
}

if (!empty($missingFiles)) {
    echo "\n❌ Missing files:\n";
    foreach ($missingFiles as $file) {
        echo "   - $file\n";
    }
} else {
    echo "\n✅ All required files exist!\n";
}

// Test 2: Check config structure
echo "\n📋 Checking config structure...\n";
if (file_exists('config/checklist.php')) {
    $config = include 'config/checklist.php';
    $categories = array_keys($config);
    $totalQuestions = 0;
    
    foreach ($config as $category => $questions) {
        $totalQuestions += count($questions);
        echo "✅ $category: " . count($questions) . " questions\n";
    }
    
    echo "✅ Total questions: $totalQuestions\n";
} else {
    echo "❌ config/checklist.php not found\n";
}

// Test 3: Check database file
echo "\n🗄️ Checking database setup...\n";
if (file_exists('database/database.sqlite')) {
    echo "✅ SQLite database file exists\n";
} else {
    echo "⚠️ SQLite database file not found (will be created on first run)\n";
}

// Test 4: Check Vercel config
echo "\n🚀 Checking Vercel deployment config...\n";
if (file_exists('vercel.json')) {
    $vercelConfig = json_decode(file_get_contents('vercel.json'), true);
    if (isset($vercelConfig['functions']['api/index.php'])) {
        echo "✅ Vercel config looks good\n";
    } else {
        echo "❌ Vercel config missing PHP function\n";
    }
} else {
    echo "❌ vercel.json not found\n";
}

echo "\n🎉 Setup test completed!\n";
echo "\n📝 Next steps:\n";
echo "1. Run: composer install\n";
echo "2. Run: php artisan key:generate\n";
echo "3. Run: php artisan migrate\n";
echo "4. Run: php artisan serve\n";
echo "5. Open: http://localhost:8000\n";
echo "\n🚀 For Vercel deployment:\n";
echo "1. Push to GitHub\n";
echo "2. Connect to Vercel\n";
echo "3. Set environment variables\n";
echo "4. Deploy!\n";
