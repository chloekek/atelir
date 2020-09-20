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
    function main(string $ownerSlug, string $projectSlug, string $slug): void
    {
        $row = $this->facilities->postgresql->queryFirst('
            SELECT
                users.name,
                projects.name,
                posts.title,
                posts.content
            FROM
                atelir.posts
                JOIN atelir.users USING (user_slug)
                JOIN atelir.projects USING (user_slug, project_slug)
            WHERE
                posts.published IS NOT NULL
                AND user_slug = $1
                AND project_slug = $2
                AND posts.post_slug = $3
        ', [$ownerSlug, $projectSlug, $slug]);

        if ($row === NULL)
            die('TODO: 404');

        assert($row[0] !== NULL);
        assert($row[1] !== NULL);
        assert($row[2] !== NULL);
        assert($row[3] !== NULL);
        $p = new Post($ownerSlug, $row[0], $row[1], $row[2], $row[3]);

        Layout::layout($p->title, function() use($p): void {
            $p->renderPost();
        });
    }
}
