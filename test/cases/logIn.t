use v5.20;
use warnings;

use LWP::UserAgent;
use Test::More;

plan(tests => 6);

# Log in with given credentials.
# Return status code and location header.
sub logIn
{
    my ($username, $password) = @_;
    my $ua = LWP::UserAgent->new(timeout => 1);
    my $url = 'http://127.0.0.1:{{ nginxPort }}/log-in';
    my %form = ( username => $username,
                 password => $password );
    my $res = $ua->post($url, \%form);
    return ($res->code, $res->header('Location'));
}

# Test log in with valid credentials.
{
    my ($statusCode, $location) = logIn('chloekek', 'hunter2');
    is($statusCode, 303);
    is($location, '/');
    # TODO: Test that user is logged in.
}

# Test log in with invalid username.
{
    my ($statusCode, $location) = logIn('chloek3k', 'hunter2');
    is($statusCode, 401);
    is($location, undef);
    # TODO: Test that user is logged out.
}

# Test log in with invalid password.
{
    my ($statusCode, $location) = logIn('chloekek', 'hunter3');
    is($statusCode, 401);
    is($location, undef);
    # TODO: Test that user is logged out.
}
