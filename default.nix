{ nixpkgs ? import ./nix/nixpkgs.nix {} }:

let
    inherit (nixpkgs) callPackage;
    software = callPackage ./software {};
    database = callPackage ./database {};
    development = callPackage ./development { inherit software; };
in
    { atelir = { inherit database development software; }; }
