<?php
    namespace Sapphire\Path;

    class PathConstructor {
        private string $path;

        public function __construct(string $path) {
            $this->path = $path;
        }

        /**
         * @name GetReal
         * 
         * Returns real path of path passed in constructor (changing @ to root directory of app)
         */
        public function GetReal(): string {
            $path = $this->path;

            // Replace @ with ../ because root dir (@) is actually 1 level below public folder which contains index.php
            $path = str_replace("@", "../", $path);

            // Return real path
            return PathConstructor::ResolvePath($path);
        }

        /**
         * Like `realpath` but works for non-existing files
         */
        public static function ResolvePath($path, $basePath=false) {
            // Make absolute path
            if (substr($path, 0, 1) !== DIRECTORY_SEPARATOR) {
                if ($basePath === true) {
                    // Get PWD first to avoid getcwd() resolving symlinks if in symlinked folder
                    $path=(getenv('PWD') ?: getcwd()).DIRECTORY_SEPARATOR.$path;
                } elseif (strlen($basePath)) {
                    $path=$basePath.DIRECTORY_SEPARATOR.$path;
                }
            }
        
            // Resolve '.' and '..'
            $components=array();
            foreach(explode(DIRECTORY_SEPARATOR, rtrim($path, DIRECTORY_SEPARATOR)) as $name) {
                if ($name === '..') {
                    array_pop($components);
                } elseif ($name !== '.' && !(count($components) && $name === '')) {
                    // … && !(count($components) && $name === '') - we want to keep initial '/' for abs paths
                    $components[]=$name;
                }
            }
        
            return implode(DIRECTORY_SEPARATOR, $components);
        }
    }