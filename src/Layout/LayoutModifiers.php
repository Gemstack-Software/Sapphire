<?php
    namespace Sapphire\Layout;

    use Sapphire\Path\PathConstructor;

    trait LayoutModifiers {
        /**
         * @name SetPath
         * 
         * Set layout's config.json file path
         */
        public function SetPath(string $path): void {
            $agent = new PathConstructor($path);

            $this->path = $agent->GetReal();
        }

        /**
         * @name GetConfig
         * 
         * Returns layout's config
         */
        public function GetConfig(): \stdClass {
            return $this->config;
        }
    }