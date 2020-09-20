<?php
declare(strict_types = 1);
namespace Atelir\Utility;

use Generator;

/**
 * This class is a thin wrapper around the pgsql extension.
 * This class is used to provide type-safety with Psalm.
 */
final
class Postgresql
{
    /** @var resource */
    private $raw;

    public
    function __construct(string $dsn)
    {
        $this->raw = \pg_connect($dsn);
    }

    /**
     * @params array<?string> $params
     * @return iterable<int,array<int,?string>>
     */
    public
    function query(string $sql, array $params = []): iterable
    {
        $result = \pg_query_params($this->raw, $sql, $params);
        for (;;) {
            /** @var false|array<int,?string> */
            $row = \pg_fetch_row($result);
            if ($row === FALSE)
                break;
            yield $row;
        }
    }

    /**
     * @param array<?string> $params
     * @return ?array<int,?string>
     */
    public
    function queryFirst(string $sql, array $params = []): ?array
    {
        foreach ($this->query($sql, $params) as $row)
            return $row;
        return NULL;
    }
}
