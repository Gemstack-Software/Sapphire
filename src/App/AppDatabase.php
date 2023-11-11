<?php
    namespace Sapphire\App;

    use Sapphire\Database\Database;
    use Sapphire\Exceptions\DatabaseCannotConnectException;

    trait AppDatabase {
        /**
         * Returns database
         */
        public function GetDatabaseHandler(): Database {
            return $this->database;
        }
    }