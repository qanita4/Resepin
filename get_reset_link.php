<?php
/**
 * Utility script to extract password reset link from Laravel log
 * Usage: php get_reset_link.php
 */

$logFile = __DIR__ . '/storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "❌ Log file not found: $logFile\n";
    exit(1);
}

// Read log file in reverse (newest first)
$lines = array_reverse(file($logFile));

// Find the reset link in the most recent log
foreach ($lines as $line) {
    if (stripos($line, 'reset') !== false && stripos($line, 'http') !== false) {
        // Extract URL from log line
        if (preg_match('/https?:\/\/[^\s<>"{}|\\^`\[\]]*/', $line, $matches)) {
            $resetUrl = $matches[0];
            
            echo "✅ Password Reset Link Found!\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "URL: " . $resetUrl . "\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
            echo "Paste this URL in your browser to reset password.\n";
            exit(0);
        }
    }
}

echo "❌ No reset link found in log.\n";
echo "   Did you submit the forgot-password form?\n";
exit(1);
