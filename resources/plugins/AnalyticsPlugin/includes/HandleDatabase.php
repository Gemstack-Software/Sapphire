<?php
    namespace Sapphire\Analytics\Handlers;

    use Sapphire\File\File;

    trait HandleDatabase {
        private function InitAnalyticsDatabase(): void {
            $app = $this->GetApp();
            $database = $app->GetDatabaseHandler();
            
            //////////////////////////////////////////
            // Get or create table
            //////////////////////////////////////////
            $table = $database->GetTable('sapphire_analytics_statistics');

            if(!$table->Exists()) 
                $this->CreateTable($database);

            $table = $database->GetTable('sapphire_analytics_statistics');

            //////////////////////////////////////////
            // Save table as property
            //////////////////////////////////////////
            $this->table = $table;
        }

        /**
         * This method creates table into the $database  
         */
        private function CreateTable($database): void {
            $file = new File(__DIR__ . "/../sql/sapphire_analytics_statistics.sql");
            $sql = $file->Read();

            $database->connection->query($sql);
        }
    }