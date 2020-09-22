<?php
declare(strict_types = 1);
namespace Atelir\Login\Web;

use Atelir\Utility\CanHandleRequest;

final
class Submit
{
    use CanHandleRequest;

    public
    function handleRequest(): void
    {
        $userSlug = \strval($_POST['username'] ?? '');
        $password = \strval($_POST['password'] ?? '');
        echo "$userSlug $password\n";
    }
}
