<?php
declare(strict_types = 1);
namespace Atelir\Utility;

/**
 * Use this trait in a class that has the necessary fields.
 * This gives you a method to generate the URI of a post.
 */
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
