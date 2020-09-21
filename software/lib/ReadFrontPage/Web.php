<?php
declare(strict_types = 1);
namespace Atelir\ReadFrontPage;

use Atelir\Utility\Facilities;
use Atelir\Utility\Layout;
use Atelir\Utility\RenderPost;

final
class Web
{
    private Facilities $facilities;

    public
    function __construct(Facilities $facilities)
    {
        $this->facilities = $facilities;
    }

    public
    function main(): void
    {
        $fps = FeaturedPost::fetch($this->facilities->postgresql);
        Layout::layout('Home', function() use($fps): void {
            foreach ($fps as $fp) {
                $fp->renderPost($fp->postUri());
            }
        });
    }
}
