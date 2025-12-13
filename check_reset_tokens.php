echo "=== Password Reset Tokens in Database ===\n";
$tokens = \DB::table('password_reset_tokens')->get();
if ($tokens->count() > 0) {
    foreach ($tokens as $token) {
        echo "Email: {$token->email}\n";
        echo "Token: " . substr($token->token, 0, 30) . "...\n";
        echo "Created: {$token->created_at}\n\n";
    }
} else {
    echo "❌ No tokens found in database\n";
}

echo "\n=== Routes ===\n";
$routes = \Route::getRoutes();
foreach ($routes as $route) {
    if (stripos($route->uri, 'password') !== false || stripos($route->uri, 'reset') !== false) {
        echo "URI: {$route->uri} | Method: " . implode(',', $route->methods) . "\n";
    }
}
