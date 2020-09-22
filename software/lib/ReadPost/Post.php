<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

use Atelir\Utility\CanRenderPost;
use Atelir\Utility\Postgresql;

final
class Post
{
    use CanRenderPost;

    public string $userSlug;
    public string $userName;
    public string $projectName;
    public string $title;
    public string $content;

    /** @psalm-pure */
    public
    function __construct(
        string $userSlug,
        string $userName,
        string $projectName,
        string $title,
        string $content
    )
    {
        $this->userSlug = $userSlug;
        $this->userName = $userName;
        $this->projectName = $projectName;
        $this->title = $title;
        $this->content = $content;
    }

    public static
    function fetch(
        Postgresql $postgresql,
        string $userSlug,
        string $projectSlug,
        string $postSlug
    ): ?Post
    {
        $row = $postgresql->queryFirst('
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
        ', [$userSlug, $projectSlug, $postSlug]);

        if ($row === NULL)
            return NULL;

        assert($row[0] !== NULL);
        assert($row[1] !== NULL);
        assert($row[2] !== NULL);
        assert($row[3] !== NULL);
        return new Post($userSlug, $row[0], $row[1], $row[2], $row[3]);
    }
}
