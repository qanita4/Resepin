$user = \App\Models\User::find(1);
echo "User: " . $user->email . "\n";

$status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $user->email]);
echo "Status: $status\n";

if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
    echo "✅ RESET_LINK_SENT\n";
} else {
    echo "❌ NOT SENT: " . $status . "\n";
}

echo "\nLog content:\n";
$log = file_get_contents(storage_path('logs/laravel.log'));
echo substr($log, -500) . "\n";
