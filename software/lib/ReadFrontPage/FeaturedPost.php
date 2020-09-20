<?php
declare(strict_types = 1);
namespace Atelir\ReadFrontPage;

use Atelir\HasPostUri;

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
