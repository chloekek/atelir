<?php
declare(strict_types = 1);
require_once __DIR__ . '/../src/setup.php';

use Atelir\Layout;

Layout::layout('Home', function(): void {
    $posts = ['Lorem ipsum', 'Hello, world!'];
    foreach ($posts as $post) {
        echo '<article>';
        echo '<h1>';
        echo \htmlentities($post);
        echo '</h1>';
        echo '</article>';
    }
});
