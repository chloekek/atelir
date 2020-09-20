<?php
declare(strict_types = 1);
namespace Atelir\Utility;

final
class RenderPost
{
    private
    function __construct()
    {
    }

    public static
    function renderPost(
        ?string $postUri,
        string $title,
        string $content,
        string $ownerSlug,
        string $ownerName,
        string $projectName
    ): void
    {
        ?><article class="atelir-post" dir="auto"><?php
            ?><aside class="-metadata"><?php
                ?><img class="-owner-avatar" src="/avatar/<?= \htmlentities($ownerSlug) ?>"><?php
                ?><p class="-owner-name"><?= \htmlentities($ownerName) ?></p><?php
                ?><p class="-project-name"><?= \htmlentities($projectName) ?></p><?php
                ?><p class="-about-project">Hello, world!</p><?php
            ?></aside><?php
            ?><section class="-content"><?php
                ?><h1><?php
                    ?><? if ($postUri !== NULL): ?><?php
                        ?><a href="<?= \htmlentities($postUri) ?>"><?php
                    ?><? endif; ?><?php
                    ?><?= \htmlentities($title) ?><?php
                    ?><? if ($postUri !== NULL): ?><?php
                        ?></a><?php
                    ?><? endif; ?><?php
                ?></h1><?php
                ?><p><?php
                    ?><?= \htmlentities($content) ?><?php
                ?></p><?php
            ?></section><?php
        ?></article><?php
    }
}
