// Check email notification class
$notificationClass = 'Illuminate\Auth\Notifications\ResetPassword';

echo "Looking for password reset notification...\n";
echo "Class: $notificationClass\n\n";

// Try to find the mailable or notification
if (class_exists('Illuminate\Auth\Notifications\ResetPassword')) {
    echo "✅ Found notification class\n";
    $reflectionClass = new ReflectionClass('Illuminate\Auth\Notifications\ResetPassword');
    echo "File: " . $reflectionClass->getFileName() . "\n";
} else {
    echo "❌ Notification class not found\n";
}

// Check log for actual reset link
echo "\n\n--- ACTUAL LINK FROM LOG ---\n";
$logFile = storage_path('logs/laravel.log');
$log = file_get_contents($logFile);

if (preg_match('/(reset-password\/[a-f0-9]+\?email=[^"<\s]+)/', $log, $matches)) {
    echo "Link: " . $matches[0] . "\n\n";
    
    // Extract parts
    preg_match('/reset-password\/([a-f0-9]+)/', $matches[0], $tokenPart);
    preg_match('/email=([^&\s]+)/', $matches[0], $emailPart);
    
    echo "Token: " . $tokenPart[1] . "\n";
    echo "Email: " . urldecode($emailPart[1]) . "\n";
}
