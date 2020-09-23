use v5.20;
use warnings;

use LWP::UserAgent;
use Test::More;

plan(tests => 2);

my $ua = LWP::UserAgent->new(timeout => 1);
my $url = 'http://127.0.0.1:{{ nginxPort }}/log-out';
my $res = $ua->post($url);
is($res->code, 303);
is($res->header('Location'), '/');

# TODO: Test that user is logged out.
