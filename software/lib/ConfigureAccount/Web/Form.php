<?php
declare(strict_types = 1);
namespace Atelir\ConfigureAccount\Web;

use Atelir\Utility\CanHandleRequest;

final
class Form
{
    use CanHandleRequest;

    public
    function handleRequest(): void
    {
        $userSlug = $this->facilities->session->getAuthenticatedUserSlug();

        if ($userSlug === NULL) {
            \header('Status: 401 Unauthorized');
            return;
        }
    }
}
