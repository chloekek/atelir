<?php
declare(strict_types = 1);
namespace Atelir;

trait HasPostUri
{
    final public
    function postUri(): string
    {
        return '/posts' .
               '/' . $this->ownerSlug .
               '/' . $this->projectSlug .
               '/' . $this->slug;
    }
}
