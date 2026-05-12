<?php
require 'vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$uri = $_ENV['MONGO_URI'] ?? getenv('MONGO_URI');

try {
    $cliente = new MongoDB\Client($uri);
    $coleccion = $cliente->app_crud->tareas;
} catch (Exception $e) {
    die("Error de conexión a MongoDB: " . $e->getMessage());
}
?>
