<?php
declare(strict_types = 1);
namespace Atelir;

trait HasPostUri
{
    final public
    function postUri(): string
    {
        return '/post' .
               '/' . $this->ownerSlug .
               '/' . $this->projectSlug .
               '/' . $this->slug;
    }
}
