<?php
    namespace Sapphire\App;

    use Sapphire\Database\Database;

    trait AppDatabase {
        /**
         * Returns database
         */
        public function GetDatabaseHandler(): Database {
            return $this->database;
        }
    }