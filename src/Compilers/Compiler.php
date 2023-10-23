<?php
    namespace Sapphire\Compilers;

    use Sapphire\Compilers\Compilable;
    use Sapphire\File\File;

    class Compiler implements Compilable {
        /**
         * Contains the engine (class instance) of compiler
         */
        protected $engine;

        /**
         * @from Compilable
         */
        public function Compile(File $entry): File {
            return $entry;
        }
    }