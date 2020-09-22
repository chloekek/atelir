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

# Assemble facilities.
$facilities = new Atelir\Utility\Facilities();

# Invoke main method.
$requestHandlerClass = $_SERVER['X_ATELIR_REQUEST_HANDLER_CLASS'];
$arguments = $_SERVER['X_ATELIR_ARGUMENTS'] ?? [];
ksort($arguments);

$requestHandler = new $requestHandlerClass($facilities);
$requestHandler->handleRequest(...$arguments);
