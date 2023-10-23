<?php
    namespace Sapphire\Plugin;

    use Sapphire\File\File;
    use Sapphire\Path\PathConstructor;
    use Sapphire\Plugin\Plugin;

    class PluginLoader {
        public static array $plugins = [];

        /**
         * Loads plugin into system
         */
        public static function Load(Plugin $plugin): void {
            static::$plugins[] = $plugin;

            $plugin->Init();
        }

        /**
         * Get plugin by it's name
         */
        public static function Get(string $name): Plugin | null {
            foreach(static::$plugins as $plugin) {
                if($plugin->GetName() === $name) return $plugin;
            }

            return null;
        }

        /**
         * Get all plugins
         */
        public static function All(): array {
            return static::$plugins;
        }

        /**
         * Load all plugins
         */
        public static function LoadAll(): void {
            $path_agent = new PathConstructor("@resources/plugins");
            $path = $path_agent->GetReal();

            $folder = new File($path);

            foreach($folder->NotSecretFilesProceed() as $file) {
                ///////////////////////////////////////////////////////////
                // Before loading plugin load all includes files
                ///////////////////////////////////////////////////////////
                $includes = $file->GetChild("includes");

                if($includes->Exists())
                    foreach($includes->NotSecretFilesProceed() as $event)
                        $event->Include();

                ///////////////////////////////////////////////////////////
                // Load Plugin entry file
                ///////////////////////////////////////////////////////////
                $entry = $file->GetChild("Plugin.entry.php");
                $plugin_class = $entry->Include();

                ///////////////////////////////////////////////////////////
                // Load config
                ///////////////////////////////////////////////////////////
                $config_file = $file->GetChild("Plugin.json");
                $config = $config_file->Json();

                ///////////////////////////////////////////////////////////
                // Create new plugin instance and load it
                ///////////////////////////////////////////////////////////
                $plugin = new $plugin_class;
                $plugin->SetConfig($config);
                $plugin->SetPath($file->GetPath()); 

                static::Load($plugin);
            }
        }

        /**
         * Provides method for firing specified event at all plugins
         */
        public static function Fire(string $event_name): void {
            foreach(static::$plugins as $plugin) {
                $plugin->FireEvent($event_name);
            }
        }
    }