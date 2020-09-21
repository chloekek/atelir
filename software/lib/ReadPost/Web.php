<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

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
    function main(
        string $userSlug,
        string $projectSlug,
        string $postSlug
    ): void
    {
        $pg = $this->facilities->postgresql;
        $p = Post::fetch($pg, $userSlug, $projectSlug, $postSlug);
        if ($p === NULL)
            die('TODO: Not Found');
        Layout::layout($p->title, function() use($p): void {
            $p->renderPost();
        });
    }
}
