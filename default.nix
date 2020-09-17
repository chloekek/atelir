{ nixpkgs ? import ./nix/nixpkgs.nix {} }:

let
    inherit (nixpkgs) callPackage;
    software = callPackage ./software {};
    development = callPackage ./development { inherit software; };
in
    { atelir = { inherit development software; }; }
