<?php
// Simple wrapper so Vercel's Functions (which must live in /api)
// can execute the Laravel `public/index.php` front controller.

// Adjust working directory to project root
chdir(__DIR__ . '/..');

// If composer autoload isn't available on the server, Vercel
// should run `composer install`. This file simply delegates to
// the standard Laravel entrypoint.
require __DIR__ . '/../public/index.php';
