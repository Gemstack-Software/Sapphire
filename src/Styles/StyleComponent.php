<?php
    namespace Sapphire\Styles;

    /**
     * This trait is used for style usage in components
     */
    trait StyleComponent { 
        /**
         * Contains all components hashed of components that has their style rendered 
         */
        public static array $component_styles_used = [];

        /**
         * Checks if component with passed hash had rendered his style
         */
        public static function HasComponentStyle(string $hash): bool {
            return in_array($hash, static::$component_styles_used);
        }

        /**
         * Saves that component with passed hash had rendered his style
         */
        public static function ComponentStyleRendered(string $hash): void {
            static::$component_styles_used[] = $hash;
        }
    }