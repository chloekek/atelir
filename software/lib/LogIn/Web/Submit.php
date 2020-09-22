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
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    private
    function authenticate(string $userSlug, string $password): bool
    {
        $row = $this->facilities->postgresql->queryFirst('
            SELECT users.password_hash
            FROM atelir.users
            WHERE users.user_slug = $1
        ', [$userSlug]);

        if ($row === NULL)
            return FALSE;

        assert($row[0] !== NULL);
        if (!\password_verify($password, $row[0]))
            return FALSE;

        return TRUE;
    }
}
