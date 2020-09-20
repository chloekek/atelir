<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

use Atelir\Utility\CanRenderPost;

final
class Post
{
    use CanRenderPost;

    public string $ownerSlug;
    public string $ownerName;
    public string $projectName;
    public string $title;
    public string $content;

    public
    function __construct(
        string $ownerSlug,
        string $ownerName,
        string $projectName,
        string $title,
        string $content
    )
    {
        $this->ownerSlug = $ownerSlug;
        $this->ownerName = $ownerName;
        $this->projectName = $projectName;
        $this->title = $title;
        $this->content = $content;
    }
}
