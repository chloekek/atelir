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
        $rows = $this->facilities->postgresql->query('
            SELECT
                owner_slug,
                owner_slug, -- TODO: Name.
                project_slug,
                project_slug, -- TODO: Name.
                slug,
                title,
                content
            FROM atelir.posts
            WHERE published IS NOT NULL
            ORDER BY published DESC
        ');

        $fps = \call_user_func(
            /** @return iterable<int,FeaturedPost> */
            function() use($rows): iterable {
                foreach ($rows as $row) {
                    assert($row[0] !== NULL);
                    assert($row[1] !== NULL);
                    assert($row[2] !== NULL);
                    assert($row[3] !== NULL);
                    assert($row[4] !== NULL);
                    assert($row[5] !== NULL);
                    assert($row[6] !== NULL);
                    yield new FeaturedPost(
                        $row[0],
                        $row[1],
                        $row[2],
                        $row[3],
                        $row[4],
                        $row[5],
                        $row[6],
                    );
                }
            },
        );

        Layout::layout('Home', function() use($fps): void {
            foreach ($fps as $fp) {
                $fp->renderPost($fp->postUri());
            }
        });
    }
}
