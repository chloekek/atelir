<?php
declare(strict_types = 1);
namespace Atelir\ReadFrontPage;

use Atelir\Utility\CanRenderPost;
use Atelir\Utility\HasPostUri;
use Atelir\Utility\Postgresql;

final
class FeaturedPost
{
    use CanRenderPost;
    use HasPostUri;

    public string $userSlug;
    public string $userName;
    public string $projectSlug;
    public string $projectName;
    public string $postSlug;
    public string $title;
    public string $content;

    /** @psalm-pure */
    public
    function __construct(
        string $userSlug,
        string $userName,
        string $projectSlug,
        string $projectName,
        string $postSlug,
        string $title,
        string $content
    )
    {
        $this->userSlug = $userSlug;
        $this->userName = $userName;
        $this->projectSlug = $projectSlug;
        $this->projectName = $projectName;
        $this->postSlug = $postSlug;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return iterable<int,FeaturedPost>
     */
    public static
    function fetch(Postgresql $postgresql): iterable
    {
        $rows = $postgresql->query('
            SELECT
                user_slug,
                users.name,
                project_slug,
                projects.name,
                posts.post_slug,
                posts.title,
                posts.content
            FROM
                atelir.posts
                JOIN atelir.users USING (user_slug)
                JOIN atelir.projects USING (user_slug, project_slug)
            WHERE posts.published IS NOT NULL
            ORDER BY posts.published DESC
        ');

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
    }
}
