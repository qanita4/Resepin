// Simulate the reset-password GET request
$request = \Illuminate\Http\Request::create(
    '/reset-password/e743ced6cd1e0fbadaae90bbc704178c18759dd99a237242d80cdefa62f67cc3?email=test%40example.com',
    'GET'
);

echo "Request URI: " . $request->getRequestUri() . "\n";
echo "Route parameter would be: " . $request->route('token') . "\n\n";

// Check if route is registered and working
$router = app('router');
try {
    $route = $router->getRoutes()->match($request);
    echo "✅ Route matched: {$route->uri}\n";
    echo "Controller: " . (isset($route->controller) ? $route->controller : 'N/A') . "\n";
} catch (\Exception $e) {
    echo "❌ Route not matched: " . $e->getMessage() . "\n";
}
