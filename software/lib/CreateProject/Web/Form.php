<?php
declare(strict_types = 1);
namespace Atelir\CreateProject\Web;

use Atelir\Utility\CanHandleRequest;

final
class Form
{
    use CanHandleRequest;

    public
    function handleRequest(): void
    {
        $this->facilities->layout->layout('New project', function(): void {
            ?><form class="atelir-new-project"
                    action="/new-project"
                    method="post"><?php
                ?><h1>New project</h1><?php
                ?><input type="text" name="name"><?php
                ?><button>Create</button><?php
            ?></form><?php
        });
    }
}
