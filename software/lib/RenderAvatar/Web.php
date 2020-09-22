<?php
declare(strict_types = 1);
namespace Atelir\RenderAvatar;

use Atelir\Utility\CanHandleRequest;

final
class Web
{
    use CanHandleRequest;

    private const COLORS = [
        '#001f3f', '#0074D9', '#7FDBFF', '#39CCCC',
        '#3D9970', '#2ECC40', '#01FF70', '#FFDC00',
        '#FF851B', '#FF4136', '#85144b', '#F012BE',
        '#B10DC9',
    ];

    public
    function handleRequest(string $userSlug): void
    {
        $hash = \sha1($userSlug, TRUE);

        \header('Content-Type: image/svg+xml');

        ?><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"><?php
        for ($i = 0; $i < 9; ++$i) {
            $d = 36 - $i * 4;
            $r = $d / 2;
            $n = \ord($hash[$i]);
            $fill = self::COLORS[$n % \count(self::COLORS)];
            ?><circle cx="18" cy="18" r="<?= $r ?>" fill="<?= $fill ?>" /><?php
        }
        ?></svg><?php
    }
}

