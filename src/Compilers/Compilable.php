<?php
    namespace Sapphire\Compilers;

    use Sapphire\File\File;

    interface Compilable {
        /**
         * @name Compile
         * 
         * Compiles {File $entry} and saves the results in temporary location and returns its as File 
         */
        public function Compile(File $entry): File;
    }