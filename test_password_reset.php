<?php
/**
 * Simulate password reset flow and extract link
 * Usage: php artisan tinker < test_password_reset.php
 */

// Clear previous log
@unlink(storage_path('logs/laravel.log'));

// Create test user if not exists
$user = \App\Models\User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password123'),
    ]
);

echo "✅ Test user created/exists: {$user->email}\n\n";

// Trigger password reset request
echo "📧 Sending password reset email...\n";
$status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => 'test@example.com']);

echo "Status: " . ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT ? '✅ SENT' : '❌ FAILED') . "\n\n";

// Extract reset link from log
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = array_reverse(file($logFile));
    foreach ($lines as $line) {
        if (stripos($line, 'reset') !== false && stripos($line, 'http') !== false) {
            if (preg_match('/https?:\/\/[^\s<>"{}|\\^`\[\]]*/', $line, $matches)) {
                echo "🔗 Reset Link:\n";
                echo $matches[0] . "\n";
                break;
            }
        }
    }
}
