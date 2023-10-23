<?php
    namespace Onyx\CLI;
    use Onyx\Compiler;

    define('ONYX_CLI', true);
    require('src/Requires/Requires.php');

    if(count($argv) < 3) {
        echo "Onyx requires arguments <filename> and <outfile>";
        exit();
    }

    $compiler = new Compiler;
    $compiler->Run(
        realpath(getcwd() . '/' . $argv[1]), 
        getcwd() . '/' . $argv[2]
    );