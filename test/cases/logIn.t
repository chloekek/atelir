use v5.20;
use warnings;

use LWP::UserAgent;
use Test::More;

plan(tests => 9);

# Log in with given credentials.
# Return status code, and location header.
# Also return status code of account page.
sub logIn
{
    my ($username, $password) = @_;
    my $ua = LWP::UserAgent->new(cookie_jar => {}, timeout => 1);

    # Attempt to log in.
    my $res = do {
        my $url = 'http://127.0.0.1:{{ nginxPort }}/log-in';
        my %form = ( username => $username,
                     password => $password );
        $ua->post($url, \%form);
    };

    # Check whether logged in.
    my $accRes = do {
        my $url = 'http://127.0.0.1:{{ nginxPort }}/account';
        $ua->get($url);
    };

    return (
        $res->code,
        scalar($res->header('Location')),
        $accRes->code,
    );
}

# Test log in with valid credentials.
{
    my ($statusCode, $location, $accStatusCode) =
        logIn('chloekek', 'hunter2');
    is($statusCode, 303);
    is($location, '/');
    is($accStatusCode, 200);
}

# Test log in with invalid username.
{
    my ($statusCode, $location, $accStatusCode) =
        logIn('chloek3k', 'hunter2');
    is($statusCode, 401);
    is($location, undef);
    is($accStatusCode, 401);
}

# Test log in with invalid password.
{
    my ($statusCode, $location, $accStatusCode) =
        logIn('chloekek', 'hunter3');
    is($statusCode, 401);
    is($location, undef);
    is($accStatusCode, 401);
}
