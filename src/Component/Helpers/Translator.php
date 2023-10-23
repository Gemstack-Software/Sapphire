<?php
    namespace Sapphire\Component\Helpers;

    use Sapphire\Locale\Locale;
    use Sapphire\Collection\Collection;
    use Sapphire\Settings\SettingsManager;

    trait Translator {
        private function GetTranslationCollectionName(): string {
            return SettingsManager::GetSetting("Internationalization", "Locales collection");
        }

        public function Translate(string $translate): string {
            $locale = Locale::Get();        
            $translations = Collection::Get($this->GetTranslationCollectionName())->Entry($locale);

            return !$translations ? "Locale $locale does not exists." : $translations->attributes->{$translate};
        }
    }