<?php
// Array of routes in German
$routes = [
    '/' => 'index.html' ,
    '/app-vitrine' => 'app-showcase.html',
    '/blog-details' => 'blog-detail.html',
    '/blog' => 'blog.html',
    '/saubere-produkte' => 'cleanproductsshowcase.html',
    '/fensterreinigung' => 'Fensterreinigung.html',
    '/haushaltsreinigungen' => 'Haushaltsreinigungen.html',
    '/liegenschaftsreinigungen' => 'Liegenschaftsreinigungen.html',
    '/überbelichtung' => 'overexposure.html',
    '/parallax-zoom-schnitte' => 'parallax-zoom-slices.html',
    '/partikel-effekt-eins' => 'particle-effect-one.html',
    '/partikel-effekt-drei' => 'particle-effect-three.html',
    '/premium-kreative-freiheit' => 'premium-creative-freedom.html',
    '/suche-gefunden' => 'search-found.html',
    '/suche-nicht-gefunden' => 'search-not-found.html',
    '/schlanke-landingpage' => 'sleek-landing-page.html',
    '/team-details' => '/team-details',
    '/team' => 'team.html',
    '/umzugsreinigungen' => 'Umzugsreinigungen.html',
    '/unterhaltsreinigungen' => 'Unterhaltsreinigungen.html',
    '/datenschutzerkärung' => 'Datenschutzerkärung.html'
];

// Get the requested URI

$requestedPath = strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Route the request to the appropriate HTML file
if (array_key_exists($requestedPath, $routes)) {
    include $routes[$requestedPath];
} else {
    // Handle 404 error
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
}
