use v5.20;
use warnings;

# This script is run at build time.
# This script is not run in production.
# The output of this script is included by nginx.conf.

# Define a new route which matches the given method and URI pattern.
# The route then instantiates the given class.
# The route then invokes the handleRequest method on the class.
# It passes the given number of arguments from the pattern’s capture groups.
sub route
{
    my ($meth, $pat, $cls, $nargs) = @_;

    print("location ~ $pat\n");
    print("{\n");

        print("fastcgi_param CONTENT_LENGTH  \$content_length;\n");
        print("fastcgi_param CONTENT_TYPE    \$content_type;\n");
        print("fastcgi_param QUERY_STRING    \$query_string;\n");
        print("fastcgi_param REQUEST_METHOD  \$request_method;\n");
        print("fastcgi_param SCRIPT_FILENAME {{ out }}/www/index.php;\n");

        print("fastcgi_param X_ATELIR_REQUEST_HANDLER_CLASS $cls;\n");
        for (1 .. $nargs) {
            print("fastcgi_param X_ATELIR_ARGUMENTS[$_] \$$_;\n");
        }

        print("fastcgi_pass 127.0.0.1:{{ phpfpmPort }};\n");

    print("}\n");
}

# Front page.
route('GET', '^/$', 'Atelir\ReadFrontPage\Web', 0);

# Log in.
route('POST', '^/log-in$', 'Atelir\LogIn\Web\Submit', 0);

# Read post.
route('GET', '^/post/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)$', 'Atelir\ReadPost\Web', 3);

# Render avatar.
route('GET', '^/avatar/([a-z0-9-]+)$', 'Atelir\RenderAvatar\Web', 1);
