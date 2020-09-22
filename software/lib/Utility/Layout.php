<?php
declare(strict_types = 1);
namespace Atelir\Utility;

/**
 * This class implements the layout.
 * The layout renders the stuff around the page content.
 * This includes the HTML boilerplate, the header, and the footer.
 */
final
class Layout
{
    private Session $session;

    public
    function __construct(Session $session)
    {
        $this->session = $session;
    }

    /** @param callable():void $body */
    public
    function layout(string $title, callable $body): void
    {
        $authenticatedUserSlug = $this->session->getAuthenticatedUserSlug();
        ?><!DOCTYPE html><?php
        ?><meta charset="utf-8"><?php
        ?><title><?= \htmlentities($title) ?> &mdash; Atelir</title><?php
        ?><link rel="stylesheet" href="/style.css"><?php
        ?><header class="atelir-header"><?php
            ?><a class="-logo" href="/">Atelir</a><?php
            ?><form class="-search" action="/search"><?php
                ?><input type="search" name="q"><?php
                ?><button>Search</button><?php
            ?></form><?php
            ?><?php if ($authenticatedUserSlug === NULL): ?><?php
                ?><form class="-log-in" action="/log-in" method="post"><?php
                    ?><input type="text" name="username"><?php
                    ?><input type="password" name="password"><?php
                    ?><button>Log in</button><?php
                ?></form><?php
            ?><?php else: ?><?php
                ?><p class="-log-in"><?php
                    ?>Hello, <?= \htmlentities($authenticatedUserSlug) ?>!<?php
                ?></p><?php
            ?><?php endif; ?><?php
            ?><nav class="-topics"><?php
                ?><ul><?php
                    ?><li><a href="/topics/gardening">Gardening</a><?php
                    ?><li><a href="/topics/technology">Technology</a><?php
                ?></ul><?php
            ?></nav><?php
        ?></header><?php
        ?><main class="atelir-content"><?php
            $body();
        ?></main><?php
        ?><footer class="atelir-footer"><?php
            ?><nav class="-miscellaneous"><?php
                ?><ul><?php
                    ?><li><a href="/about">About</a><?php
                    ?><li><a href="/tos">Terms of service</a><?php
                    ?><li><a href="/privacy">Privacy policy</a><?php
                    ?><li><a href="/cookies">Cookies</a><?php
                ?></ul><?php
            ?></nav><?php
        ?></footer><?php
    }
}
