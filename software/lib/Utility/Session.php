<?php
declare(strict_types = 1);
namespace Atelir\Utility;

final
class Session
{
    public
    function setAuthenticatedUserSlug(?string $userSlug): void
    {
        $_SESSION['authenticatedUserSlug'] = $userSlug;
    }

    public
    function getAuthenticatedUserSlug(): ?string
    {
        /** @var ?string */
        $result = $_SESSION['authenticatedUserSlug'] ?? NULL;
        return $result;
    }
}
