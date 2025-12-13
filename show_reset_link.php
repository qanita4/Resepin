$logFile = storage_path('logs/laravel.log');
$log = file_get_contents($logFile);

// Find reset link URL
if (preg_match('/https?:\/\/[^\s<>"\']*password[^\s<>"\']*/', $log, $matches)) {
    $resetUrl = $matches[0];
    echo "\n✅ PASSWORD RESET LINK FOUND!\n";
    echo "═══════════════════════════════════════════════════\n\n";
    echo "🔗 URL:\n";
    echo $resetUrl . "\n\n";
    echo "═══════════════════════════════════════════════════\n\n";
    
    // Extract token
    if (preg_match('/reset-password\/([a-f0-9]+)/', $resetUrl, $tokenMatch)) {
        echo "🔐 Token: " . substr($tokenMatch[1], 0, 30) . "...\n\n";
    }
    
    echo "📋 NEXT STEPS:\n";
    echo "   1. Copy the URL above\n";
    echo "   2. Paste in your browser\n";
    echo "   3. Enter new password\n";
    echo "   4. Click reset button\n";
    echo "   5. Login with new password\n\n";
} else {
    echo "❌ Reset link not found in log\n";
}
