<?php
declare(strict_types = 1);
namespace Atelir\Utility;

/**
 * This class exposes facilities for the application to work with.
 * Do not instantiate this class anywhere except in www/index.php.
 * An instance of this class is passed to the constructor of every main class.
 */
final
class Facilities
{
    public Postgresql $postgresql;

    public
    function __construct()
    {
        $this->postgresql = new Postgresql('
            host=127.0.0.1
            port={{ postgresqlPort }}
            user=atelir_software
            password=atelir_software
            dbname=atelir
        ');
    }
}
