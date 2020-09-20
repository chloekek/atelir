<?php
declare(strict_types = 1);
namespace Atelir\ReadPost;

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
