<?php
    namespace Sapphire\Database;

    use Sapphire\Setup\SetupInterface;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Exceptions\DatabaseCannotConnectException;
    use PDO;
    use PDOException;

    trait DatabaseSetup {
        /**
         * @name Setup
         * 
         * Create database connection
         */
        public function Setup(): void {
            // Database Config
            $config = $this->config;

            $host = $config->host;
            $user = $config->user;
            $pass = $config->pass;
            $name = $config->name;

            // Connecting using PDO
            try {
                $this->connection = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
                $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException) {
                throw new DatabaseCannotConnectException("Cannot connect to database!");
            }

            // Checking if database has been setted up
            if($table = $this->GetTable('sapphire')) {
                if(!$table->Exists()) $this->ImportDatabase();
            }
        }

        /**
         * @name ImportDatabase
         * 
         * Imports whole empty sapphire database
         */
        private function ImportDatabase(): void {
            $database_path_agent = new PathConstructor('@/src/Database/Tables');
            $database_path = $database_path_agent->GetReal();

            foreach(scandir($database_path) as $table) {
                if(File::IsTravellerFolder($table)) continue;

                $table_path_agent = new PathConstructor("@/src/Database/Tables/$table");
                $table_path = $table_path_agent->GetReal();

                $table_file = new File($table_path);
                $table_sql = $table_file->Read();

                if(!$table_sql) continue;
                
                $this->connection->query($table_sql);
            }
        }
    }