{ bash, makeWrapper, postgresql_12, stdenvNoCC }:

{ ports }:

stdenvNoCC.mkDerivation {
    name = "atelir-database";

    src = ./.;

    buildInputs = [
        makeWrapper
    ];

    postgresql = postgresql_12;

    postgresqlPort = ports.postgresql;

    buildPhase = ''
        # Substitute variables into setup script.
        sed --in-place --file=- bin/setupDatabase <<SED
            s:{{ postgresqlPort }}:$postgresqlPort:g
        SED
    '';

    installPhase = ''
        mkdir "$out"

        mv bin "$out"

        wrapProgram                           \
            "$out"/bin/ensureCluster          \
            --prefix PATH : "$postgresql"/bin

        wrapProgram                           \
            "$out"/bin/setupDatabase          \
            --prefix PATH : "$postgresql"/bin
    '';
}
