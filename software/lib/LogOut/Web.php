<?php
declare(strict_types = 1);
namespace Atelir\LogOut;

use Atelir\Utility\CanHandleRequest;

final
class Web
{
    use CanHandleRequest;

    public
    function handleRequest(): void
    {
        $this->facilities->session->setAuthenticatedUserSlug(NULL);
        header('Status: 303 See Other');
        header('Location: /');
    }
}
