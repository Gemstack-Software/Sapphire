<?php
    namespace Sapphire\Locale;

    use Sapphire\Settings\SettingsManager;

    class Locale {
        public static function Get(): string {
            return SettingsManager::GetSetting("Internationalization", "Default locale");
        } 
    }