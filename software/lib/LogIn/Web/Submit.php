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
        $ok = $this->authenticate($userSlug, $password);
        if ($ok) {
            $this->facilities->session->setAuthenticatedUserSlug($userSlug);
            \header('Status: 303 See Other');
            \header('Location: /');
            echo 'yes';
        } else {
            \header('Status: 401 Unauthorized');
            echo 'no';
        }
    }

    private
    function authenticate(string $userSlug, string $password): bool
    {
        $hash = $this->fetchPasswordHash($userSlug);
        if ($hash === NULL)
            return FALSE;
        return \password_verify($password, $hash);
    }

    private
    function fetchPasswordHash(string $userSlug): ?string
    {
        $row = $this->facilities->postgresql->queryFirst('
            SELECT users.password_hash
            FROM atelir.users
            WHERE users.user_slug = $1
        ', [$userSlug]);
        if ($row === NULL)
            return NULL;
        return $row[0];
    }
}
