{ makeWrapper, nginx, php, stdenvNoCC }:

{ ports }:

let
    phpExtensions = p: [
        p.dom
        p.filter
        p.iconv
        p.json
        p.openssl
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
        ];

        inherit nginx;
        php = phpWithExtensions;

        nginxPort = ports.nginx;
        phpfpmPort = ports.phpfpm;

        buildPhase = ''
            # Generate PHP autoloader.
            # This generates the vendor directory.
            composer update

            # Type-check PHP source code.
            psalm

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
        '';

        installPhase = ''
            mkdir "$out"
            mv bin etc src vendor www "$out"
        '';
    }
