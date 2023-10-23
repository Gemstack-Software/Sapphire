<?php
    namespace Sapphire\Settings;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class SettingsManager {
        /**
         * Returns all sapphire settings from file
         * ==========================================================================================
         * INFO:
         * 
         * Sapphire settings are located in folder: @resources/configs in file: App.json
         * It contains only some part of settings (excluding: Access and users (it's in database))
         * 
         */
        public static function GetAll(): \stdClass | null {
            /////////////////////////////////////////
            // Get the settings file
            /////////////////////////////////////////
            $path_agent = new PathConstructor("@resources/configs/App.json");
            $path = $path_agent->GetReal();
            $settings_file = new File($path);

            /////////////////////////////////////////
            // Return settings or null
            /////////////////////////////////////////
            return $settings_file->Exists() ? $settings_file->Json() : null;
        }

        /**
         * Return setting value
         */
        public static function GetSetting(string $category, string $setting) {
            $settings = static::GetAll();

            return $settings->{$category}->{$setting};
        }

        /**
         * Saves settings to file
         */
        public static function Save(\stdClass $settings): bool {
            /////////////////////////////////////////
            // Get the settings file
            /////////////////////////////////////////
            $path_agent = new PathConstructor("@resources/configs/App.json");
            $path = $path_agent->GetReal();
            $settings_file = new File($path);

            /////////////////////////////////////////
            // Write json
            /////////////////////////////////////////
            $settings_file->Json($settings);

            return true;
        }
    }