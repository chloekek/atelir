{ nixpkgs ? import ./nix/nixpkgs.nix {} }:

let
    inherit (nixpkgs) callPackage;
    test = callPackage ./test { inherit database development; };
    software = callPackage ./software {};
    database = callPackage ./database {};
    development = callPackage ./development { inherit software; };
in
    { atelir = { inherit database development software test; }; }
