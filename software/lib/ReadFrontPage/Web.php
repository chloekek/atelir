<?php
declare(strict_types = 1);
namespace Atelir\ReadFrontPage;

use Atelir\Utility\CanHandleRequest;
use Atelir\Utility\Layout;
use Atelir\Utility\RenderPost;

final
class Web
{
    use CanHandleRequest;

    public
    function handleRequest(): void
    {
        $fps = FeaturedPost::fetch($this->facilities->postgresql);
        $this->facilities->layout->layout('Home', function() use($fps): void {
            foreach ($fps as $fp) {
                $fp->renderPost($fp->postUri());
            }
        });
    }
}
