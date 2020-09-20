<?php
declare(strict_types = 1);
require_once __DIR__ . '/../lib/setup.php';

use Atelir\Layout;

$ownerSlug   = \strval($_GET['ownerSlug'] ?? '');
$projectSlug = \strval($_GET['projectSlug'] ?? '');
$slug        = \strval($_GET['slug'] ?? '');

final
class Post
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

$row = $postgresql->queryFirst('
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

Layout::layout($p->title, function() use($p): void {
    ?><p><?php
        ?><?= \htmlentities($p->content) ?><?php
    ?></p><?php
});
