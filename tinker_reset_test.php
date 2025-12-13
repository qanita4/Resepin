// Clear old log
@unlink(storage_path('logs/laravel.log'));

// Create test user
$user = \App\Models\User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password123'),
    ]
);

echo "✅ User created: {$user->email}\n";

// Send reset link
$status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => 'test@example.com']);
echo "📧 Reset link status: " . ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT ? '✅ SENT' : '❌ FAILED') . "\n\n";

// Extract from log
$log = file_get_contents(storage_path('logs/laravel.log'));
if (preg_match('/https?:\/\/[^\s<>"{}|\\^`\[\]]*password[^\s<>"{}|\\^`\[\]]*/', $log, $m)) {
    echo "🔗 RESET LINK:\n";
    echo $m[0] . "\n";
} else {
    echo "❌ No reset link found in log\n";
}
