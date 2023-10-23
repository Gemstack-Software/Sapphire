<?php
    namespace Sapphire\Page;

    trait PageSaver {
        /**
         * @name Save
         * 
         * Updates page to database
         */
        public function Save(): void {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');

            $table->UpdateSingle($this->ToArray(), whereId: $this->id);
        }
    }