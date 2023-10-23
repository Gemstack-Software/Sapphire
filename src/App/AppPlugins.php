<?php
    namespace Sapphire\App;

    use Sapphire\Plugin\PluginLoader;

    trait AppPlugins {
        /**
         * Load all plugins into Sapphire
         */
        public function LoadPlugins() {
            PluginLoader::LoadAll();
        }
    }