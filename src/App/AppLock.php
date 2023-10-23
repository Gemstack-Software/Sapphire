<?php
    namespace Sapphire\App;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    trait AppLock {
        /**
         * @name GetLock
         * 
         * Returns @/lock.json file content as json
         */
        public function GetLock(): \stdClass {
            $file_path_agent = new PathConstructor('@/lock.json');
            $file_path = $file_path_agent->GetReal();

            $file = new File($file_path);

            return $file->Json();
        }
    }