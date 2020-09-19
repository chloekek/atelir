<?php
declare(strict_types = 1);
namespace Atelir;

final
class Layout
{
    private
    function __construct()
    {
    }

    /** @param callable():void $body */
    public static
    function layout(string $title, callable $body): void
    {
        ?><!DOCTYPE html><?php
        ?><meta charset="utf-8"><?php
        ?><title><?= \htmlentities($title) ?> &mdash; Atelir</title><?php
        ?><link rel="stylesheet" href="/style.css"><?php
        ?><header><?php
            ?><a class="-logo" href="/">Atelir</a><?php
            ?><form class="-search" action="/search"><?php
                ?><input type="search" name="q"><?php
                ?><button>Search</button><?php
            ?></form><?php
            ?><nav class="-topics"><?php
                ?><ul><?php
                    ?><li><a href="/topics/business">Business</a><?php
                    ?><li><a href="/topics/charity">Charity</a><?php
                    ?><li><a href="/topics/gardening">Gardening</a><?php
                    ?><li><a href="/topics/technology">Technology</a><?php
                ?></ul><?php
            ?></nav><?php
        ?></header><?php
        ?><section><?php
            ?><h1 class="-title"><?= \htmlentities($title) ?></h1><?php
            $body();
        ?></section><?php
        ?><footer><?php
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
