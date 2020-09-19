{ makeWrapper, nginx, php, postgresql_12, sassc, stdenvNoCC }:

{ ports }:

let
    phpExtensions = p: [
        p.dom
        p.filter
        p.iconv
        p.json
        p.openssl
        p.pgsql
        p.simplexml
        p.tokenizer
    ];
    phpWithExtensions = php.withExtensions ({ all, ... }: phpExtensions all);
in
    stdenvNoCC.mkDerivation {
        name = "atelir-software";

        src = ./.;

        buildInputs = [
            makeWrapper
            phpWithExtensions.packages.composer
            phpWithExtensions.packages.psalm
            sassc
        ];

        inherit nginx;
        php = phpWithExtensions;
        postgresql = postgresql_12;

        nginxPort = ports.nginx;
        phpfpmPort = ports.phpfpm;
        postgresqlPort = ports.postgresql;

        buildPhase = ''
            # Substitute variables into software setup file.
            sed --in-place --file=- lib/setup.php <<SED
                s:{{ postgresqlPort }}:$postgresqlPort:g
            SED

            # Substitute variables into Nginx configuration file.
            sed --in-place --file=- etc/nginx.conf <<SED
                s:{{ nginxPort }}:$nginxPort:g
                s:{{ phpfpmPort }}:$phpfpmPort:g
                s:{{ out }}:$out:g
            SED

            # Substitute variables into PHP-FPM configuration file.
            sed --in-place --file=- etc/php-fpm.conf <<SED
                s:{{ phpfpmPort }}:$phpfpmPort:g
            SED

            # Substitute variables into PostgreSQL configuration file.
            sed --in-place --file=- etc/postgresql.conf <<SED
                s:{{ postgresqlPort }}:$postgresqlPort:g
                s:{{ out }}:$out:g
            SED

            # Compile Sass.
            sassc --precision=10 www/style.scss www/style.css

            # Generate PHP autoloader.
            # This generates the vendor directory.
            composer update

            # Type-check PHP source code.
            psalm

            # Generate wrapper for nginx.
            makeWrapper                           \
                "$nginx"/bin/nginx                \
                bin/nginx                         \
                --add-flags -c                    \
                --add-flags "$out"/etc/nginx.conf \
                --add-flags -p                    \
                --add-flags '$PWD'/state/nginx

            # Generate wrapper for php-fpm.
            makeWrapper                             \
                "$php"/bin/php-fpm                  \
                bin/php-fpm                         \
                --add-flags -c                      \
                --add-flags "$out"/etc/php.ini      \
                --add-flags -p                      \
                --add-flags '$PWD'/state/php-fpm    \
                --add-flags -y                      \
                --add-flags "$out"/etc/php-fpm.conf

            # Generate wrapper for postgres.
            makeWrapper                                              \
                "$postgresql"/bin/postgres                           \
                bin/postgres                                         \
                --add-flags --config-file="$out"/etc/postgresql.conf \
                --add-flags -k                                       \
                --add-flags '$PWD'/state/postgresql
        '';

        installPhase = ''
            mkdir "$out"
            mv bin etc lib vendor www "$out"
        '';
    }
