<?php
declare(strict_types = 1);

# Throw exceptions when something goes wrong.
set_error_handler(
    function($severity, $message, $file = '', $line = 0, $context = []) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
);

# Set up the autoloader.
require_once __DIR__ . '/../supplier/autoload.php';

# Start sessions.
session_start();

# Assemble facilities.
$facilities = new Atelir\Utility\Facilities();

# Find request handler class.
$requestHandlerClasses = $_SERVER['X_ATELIR_REQUEST_HANDLER_CLASSES'];
$requestHandlerClass =
    $requestHandlerClasses[$_SERVER['REQUEST_METHOD']] ?? NULL;
if ($requestHandlerClass === NULL) {
    header('Status: 405 Method Not Allowed');
    die('405 Method Not Allowed');
}

# Find arguments.
$arguments = $_SERVER['X_ATELIR_ARGUMENTS'] ?? [];
ksort($arguments);

# Invoke request handler.
$requestHandler = new $requestHandlerClass($facilities);
$requestHandler->handleRequest(...$arguments);
