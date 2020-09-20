<?php
declare(strict_types = 1);
namespace Atelir;

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
