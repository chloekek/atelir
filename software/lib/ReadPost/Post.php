<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

use Atelir\Utility\CanRenderPost;

final
class Post
{
    use CanRenderPost;

    public string $userSlug;
    public string $userName;
    public string $projectName;
    public string $title;
    public string $content;

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
}
