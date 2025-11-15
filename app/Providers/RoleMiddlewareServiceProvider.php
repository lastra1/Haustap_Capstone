<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\RoleMiddleware;

class RoleMiddlewareServiceProvider extends ServiceProvider
{
    public function boot(Router $router): void
    {
        // Register the 'role' route middleware alias
        $router->aliasMiddleware('role', RoleMiddleware::class);
    }
}