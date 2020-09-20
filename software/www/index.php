<?php
declare(strict_types = 1);
require_once __DIR__ . '/../lib/setup.php';

use Atelir\HasPostUri;
use Atelir\Layout;
use Atelir\RenderPost;

final
class FeaturedPost
{
    use HasPostUri;

    public string $ownerSlug;
    public string $projectSlug;
    public string $slug;
    public string $title;
    public string $content;

    public
    function __construct(
        string $ownerSlug,
        string $projectSlug,
        string $slug,
        string $title,
        string $content
    )
    {
        $this->ownerSlug = $ownerSlug;
        $this->projectSlug = $projectSlug;
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }
}

$rows = $postgresql->query('
    SELECT owner_slug, project_slug, slug, title, content
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
            yield new FeaturedPost($row[0], $row[1], $row[2], $row[3], $row[4]);
        }
    },
);

Layout::layout('Home', function() use($fps): void {
    foreach ($fps as $fp) {
        RenderPost::renderPost(
            $fp->postUri(),
            $fp->title,
            $fp->content,
            $fp->ownerSlug,
            $fp->ownerSlug,
            $fp->projectSlug,
        );
    }
});
