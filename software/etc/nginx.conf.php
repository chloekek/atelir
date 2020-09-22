# This file is generated using PHP.
# PHP is used as a templating language for this file.
# Do not confuse this with our use of PHP for implementing the application.

# We use either Hivemind or systemd.
# We do not want Nginx to daemonize itself.
daemon off;

# Configure these to be relative to the prefix path.
# The prefix path is passed by the Nix-generated wrapper.
error_log error.log;
pid nginx.pid;

events
{
}

http
{
    # Configure these to be relative to the prefix path.
    # The prefix path is passed by the Nix-generated wrapper.
    access_log            access.log;
    client_body_temp_path client_body_temp;
    fastcgi_temp_path     fastcgi_temp;
    proxy_temp_path       proxy_temp;
    scgi_temp_path        scgi_temp;
    uwsgi_temp_path       uwsgi_temp;

    types {
        text/css css;
    }

    server
    {
        listen {{ nginxPort }};

        # BEGIN OF ROUTES

        <?php
            function route(string $pat, string $cls, int $nargs): string
            {
                $arguments = array_map(fn($i) => "&arguments[]=\$$i",
                                       $nargs > 0 ? range(1, $nargs) : []);
                return "rewrite $pat /index.php?requestHandlerClass=$cls" .
                       implode('', $arguments) .
                       "? last;\n";
            }
        ?>

        <?= route('^/$', 'Atelir\ReadFrontPage\Web', 0) ?>
        <?= route('^/avatar/([a-z0-9-]+)$', 'Atelir\RenderAvatar\Web', 1) ?>
        <?= route('^/post/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)$', 'Atelir\ReadPost\Web', 3) ?>

        rewrite ^/style.css$ /style.css last;
        return 404;

        # END OF ROUTES

        location ~ \.css$
        {
            root {{ out }}/www;
        }

        location = /index.php
        {
            fastcgi_param CONTENT_LENGTH $content_length;
            fastcgi_param CONTENT_TYPE   $content_type;
            fastcgi_param QUERY_STRING   $query_string;
            fastcgi_param REQUEST_METHOD $request_method;
            fastcgi_param SCRIPT_FILENAME {{ out }}/www/index.php;
            fastcgi_pass 127.0.0.1:{{ phpfpmPort }};
        }
    }
}
