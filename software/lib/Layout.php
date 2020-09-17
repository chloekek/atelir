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
        ?><section><?php
            ?><h1><?= \htmlentities($title) ?></h1><?php
            $body();
        ?></section><?php
        ?><footer><?php
            ?><nav><?php
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
