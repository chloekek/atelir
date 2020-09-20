<?php
declare(strict_types = 1);
namespace Atelir\Utility;

/**
 * Use this trait in a class that has the necessary fields.
 * This gives you a method to render a post.
 */
trait CanRenderPost
{
    final public
    function renderPost(?string $postUri = NULL): void
    {
        ?><article class="atelir-post" dir="auto"><?php
            ?><aside class="-metadata"><?php
                ?><img class="-owner-avatar" src="/avatar/<?= \htmlentities($this->ownerSlug) ?>"><?php
                ?><p class="-owner-name"><?= \htmlentities($this->ownerName) ?></p><?php
                ?><p class="-project-name"><?= \htmlentities($this->projectName) ?></p><?php
                ?><p class="-about-project">Hello, world!</p><?php
            ?></aside><?php
            ?><section class="-content"><?php
                ?><h1><?php
                    ?><? if ($postUri !== NULL): ?><?php
                        ?><a href="<?= \htmlentities($postUri) ?>"><?php
                    ?><? endif; ?><?php
                    ?><?= \htmlentities($this->title) ?><?php
                    ?><? if ($postUri !== NULL): ?><?php
                        ?></a><?php
                    ?><? endif; ?><?php
                ?></h1><?php
                ?><p><?php
                    ?><?= \htmlentities($this->content) ?><?php
                ?></p><?php
            ?></section><?php
        ?></article><?php
    }
}
