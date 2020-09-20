<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

use Atelir\Facilities;
use Atelir\Layout;
use Atelir\RenderPost;

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
    function main(string $ownerSlug, string $projectSlug, string $slug): void
    {
        $row = $this->facilities->postgresql->queryFirst('
            SELECT title, content
            FROM atelir.posts
            WHERE
                published IS NOT NULL
                AND owner_slug = $1
                AND project_slug = $2
                AND slug = $3
        ', [$ownerSlug, $projectSlug, $slug]);

        if ($row === NULL)
            die('TODO: 404');

        assert($row[0] !== NULL);
        assert($row[1] !== NULL);
        $p = new Post($row[0], $row[1]);

        Layout::layout($p->title, function() use($p, $ownerSlug, $projectSlug): void {
            RenderPost::renderPost(
                NULL,
                $p->title,
                $p->content,
                $ownerSlug,
                $ownerSlug,
                $projectSlug,
            );
        });
    }
}
