<?php
namespace App\Controllers\Guest;

final class HomeController {
    public function index(): void {
        // Keep asset paths intact by redirecting to the existing page
        // Redirect to the client homepage file so '/' serves the client view
        header('Location: /client/homepage.php', true, 302);
        exit;
    }
}