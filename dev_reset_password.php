#!/usr/bin/env php
<?php
/**
 * Natural Password Reset Test Workflow
 * 
 * Cara pakai:
 *   php dev_reset_password.php <email> [password]
 * 
 * Contoh:
 *   php dev_reset_password.php test@example.com newpassword123
 */

$email = $argv[1] ?? 'test@example.com';
$newPassword = $argv[2] ?? 'newpassword123';

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Natural Password Reset Test Workflow                   ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Create/get test user
echo "📝 Step 1: Create/Get Test User\n";
echo "   Email: $email\n";
$user = User::firstOrCreate(
    ['email' => $email],
    [
        'name' => 'Test User',
        'password' => bcrypt('password123'),
    ]
);
echo "   ✅ User ready (ID: {$user->id})\n\n";

// Step 2: Send reset link
echo "📧 Step 2: Send Password Reset Email\n";
@unlink(storage_path('logs/laravel.log'));
$status = Password::sendResetLink(['email' => $email]);

if ($status === Password::RESET_LINK_SENT) {
    echo "   ✅ Reset link email sent to log\n\n";
} else {
    echo "   ❌ Failed to send reset link\n";
    exit(1);
}

// Step 3: Extract reset link
echo "🔗 Step 3: Extract Reset Link from Log\n";
$log = file_get_contents(storage_path('logs/laravel.log'));
if (preg_match('/https?:\/\/[^\s<>"{}|\\^`\[\]]*password[^\s<>"{}|\\^`\[\]]*/', $log, $m)) {
    $resetUrl = $m[0];
    echo "   ✅ Reset link found:\n\n";
    echo "   📎 URL: $resetUrl\n\n";
} else {
    echo "   ❌ Reset link not found in log\n";
    exit(1);
}

// Step 4: Extract token
preg_match('/reset-password\/([a-f0-9]+)\?email=/', $resetUrl, $tokenMatch);
$token = $tokenMatch[1] ?? null;

if (!$token) {
    echo "   ❌ Cannot extract token\n";
    exit(1);
}

echo "   🔐 Token: " . substr($token, 0, 20) . "...\n\n";

// Step 5: Test reset (using tinker-like approach)
echo "🔄 Step 5: Test Password Reset\n";
echo "   New password will be: $newPassword\n";

// Check if reset token is valid
$tokenValid = Password::tokenExists($user, $token);
echo "   Token valid: " . ($tokenValid ? '✅ YES' : '❌ NO') . "\n\n";

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    NEXT STEPS                              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "Option 1: Use Browser\n";
echo "   1. Copy reset URL above\n";
echo "   2. Paste in browser\n";
echo "   3. Enter new password\n";
echo "   4. Submit form\n";
echo "   5. Login with new password\n\n";

echo "Option 2: Use Artisan Command (when available)\n";
echo "   php artisan reset:password --email=$email --password=$newPassword --token=$token\n\n";

echo "Option 3: Query DB directly\n";
echo "   SELECT * FROM password_reset_tokens WHERE email = '$email';\n\n";
