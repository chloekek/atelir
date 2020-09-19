<?php
declare(strict_types = 1);

# This source file should be called by every web page.
# It should be called before that web page does anything else.
# It sets up the PHP autoloader and error handling routine.
# It also does the dependency injection wiring.
# Facilities are exposed as variables.

# Throw exceptions when something goes wrong.
set_error_handler(
    /** @return never-return */
    function(int $severity, string $message, string $file = '',
             int $line = 0, array $context = []) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
);

# Set up the autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

# Connect to PostgreSQL.
$postgresql = new Atelir\Postgresql('
    host=127.0.0.1
    port={{ postgresqlPort }}
    user=atelir_software
    password=atelir_software
    dbname=atelir
');
