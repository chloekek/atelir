<?php
declare(strict_types = 1);
namespace Atelir\ReadFrontPage;

use Atelir\Utility\CanRenderPost;
use Atelir\Utility\HasPostUri;

final
class FeaturedPost
{
    use CanRenderPost;
    use HasPostUri;

    public string $userSlug;
    public string $userName;
    public string $projectSlug;
    public string $projectName;
    public string $slug;
    public string $title;
    public string $content;

    public
    function __construct(
        string $userSlug,
        string $userName,
        string $projectSlug,
        string $projectName,
        string $slug,
        string $title,
        string $content
    )
    {
        $this->userSlug = $userSlug;
        $this->userName = $userName;
        $this->projectSlug = $projectSlug;
        $this->projectName = $projectName;
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }
}
