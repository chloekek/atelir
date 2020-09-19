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
        # Substitute variables into scripts.
        sed --in-place --file=- bin/{{seed,setup}Database,migrateSchema} <<SED
            s:{{ postgresqlPort }}:$postgresqlPort:g
        SED
    '';

    installPhase = ''
        mkdir "$out"

        mv bin "$out"

        ln --symbolic "$postgresql"/bin/psql "$out"/bin

        wrapProgram                           \
            "$out"/bin/ensureCluster          \
            --prefix PATH : "$postgresql"/bin

        wrapProgram                           \
            "$out"/bin/setupDatabase          \
            --prefix PATH : "$postgresql"/bin

        wrapProgram                           \
            "$out"/bin/migrateSchema          \
            --prefix PATH : "$postgresql"/bin

        wrapProgram                           \
            "$out"/bin/seedDatabase           \
            --prefix PATH : "$postgresql"/bin
    '';
}
