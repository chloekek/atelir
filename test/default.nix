{ database, development, makeWrapper, perl, stdenvNoCC }:

{ ports }:

stdenvNoCC.mkDerivation {
    name = "atelir-test";

    src = ./.;

    buildInputs = [
        makeWrapper
    ];

    perl = perl.withPackages (p: [ p.LWPUserAgent ]);

    nginxPort = ports.nginx;

    buildPhase = ''
        # Substitute variables into test case files.
        sed --in-place --file=- cases/*.t <<SED
            s:{{ nginxPort }}:$nginxPort:g
        SED

        # Generate wrapper for prove.
        makeWrapper                  \
            "$perl"/bin/prove        \
            bin/prove                \
            --add-flags "$out"/cases
    '';

    installPhase = ''
        mkdir "$out"
        mv bin cases "$out"
    '';
}
