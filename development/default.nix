{ hivemind, makeWrapper, stdenvNoCC, software }:

{ ports }:

stdenvNoCC.mkDerivation {
    name = "atelir-development";

    src = ./.;

    buildInputs = [
        makeWrapper
    ];

    inherit hivemind;
    software = software { inherit ports; };

    buildPhase = ''
        # Substitute variables into Procfile file.
        sed --in-place --file=- etc/Procfile <<SED
            s:{{ software }}:$software:g
        SED

        # Generate wrapper for hivemind.
        makeWrapper                         \
            "$hivemind"/bin/hivemind        \
            bin/hivemind                    \
            --add-flags --root              \
            --add-flags '$PWD'              \
            --add-flags "$out"/etc/Procfile
    '';

    installPhase = ''
        mkdir "$out"/
        mv bin etc "$out"
    '';
}
