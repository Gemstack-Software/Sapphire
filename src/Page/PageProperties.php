<?php
    namespace Sapphire\Page;

    trait PageProperties {
        public function Properties(): array {
            global $app;
            
            ////////////////////////////////
            // Get database and table
            ////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages_properties');

            ////////////////////////////////
            // Get properties from table
            ////////////////////////////////
            return $table->AllWhere([
                ["page_id", "=", $this->GetId()]
            ]);
        }
    }