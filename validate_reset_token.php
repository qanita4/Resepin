// Validate token dari log
$logFile = storage_path('logs/laravel.log');
$log = file_get_contents($logFile);

if (preg_match('/reset-password\/([a-f0-9]+)\?email=([^"<\s]+)/', $log, $matches)) {
    $token = $matches[1];
    $email = urldecode($matches[2]);
    
    echo "🔍 Token from log: " . substr($token, 0, 30) . "...\n";
    echo "📧 Email from log: $email\n\n";
    
    // Check token in DB
    $dbToken = \DB::table('password_reset_tokens')
        ->where('email', $email)
        ->first();
    
    if ($dbToken) {
        echo "✅ Token exists in database\n";
        echo "DB Email: {$dbToken->email}\n";
        echo "DB Token: " . substr($dbToken->token, 0, 30) . "...\n";
        echo "Created: {$dbToken->created_at}\n\n";
        
        // Verify token
        $tokenValid = \Illuminate\Support\Facades\Password::tokenExists(
            \App\Models\User::where('email', $email)->first(),
            $token
        );
        echo "Token valid: " . ($tokenValid ? '✅ YES' : '❌ NO') . "\n";
    } else {
        echo "❌ Token NOT found in database for email: $email\n";
    }
} else {
    echo "❌ Could not extract token from log\n";
}
