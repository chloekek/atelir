<?php
declare(strict_types = 1);
namespace Atelir\Utility;

/**
 * This trait creates a constructor and exposes facilities.
 * Use this trait in classes that are meant to be called by index.php.
 */
trait CanHandleRequest
{
    private Facilities $facilities;

    /** @psalm-pure */
    public
    function __construct(Facilities $facilities)
    {
        $this->facilities = $facilities;
    }
}
