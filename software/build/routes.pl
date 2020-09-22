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

    print("if (\$request_method = $meth) {\n");

        print("rewrite $pat /index.php?requestHandlerClass=$cls");
        print("&arguments[]=\$$_") for 1 .. $nargs;
        print("? last;\n");

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
