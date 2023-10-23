<?php
    namespace Sapphire\Page;

    trait PageHome {
        /**
         * Removes `is_home` (set it to 0) to all pages
         */
        public static function ClearHomePage(): void {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');

            $table->UpdateAll([
                'is_home' => false,
            ]);
        }
    }