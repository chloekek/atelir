<?php
declare(strict_types = 1);
require_once __DIR__ . '/../lib/setup.php';

use Atelir\Layout;

final
class FeaturedPost
{
    public string $title;
    public string $content;

    public
    function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
}

$rows = $postgresql->query('
    SELECT title, content
    FROM atelir.posts
    WHERE published IS NOT NULL
    ORDER BY published DESC
');

$fps = call_user_func(
    /** @return iterable<int,FeaturedPost> */
    function() use($rows): iterable {
        foreach ($rows as $row) {
            assert($row[0] !== NULL);
            assert($row[1] !== NULL);
            yield new FeaturedPost($row[0], $row[1]);
        }
    },
);

Layout::layout('Home', function() use($fps): void {
    foreach ($fps as $fp) {
        echo '<article class="atelir-post" dir="auto">';
        echo '<h1>';
        echo \htmlentities($fp->title);
        echo '</h1>';
        echo '<p>';
        echo \htmlentities($fp->content);
        echo '</p>';
        echo '</article>';
    }
});
