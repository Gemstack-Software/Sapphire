<?php
    namespace Sapphire\Database;

    use Sapphire\Setup\SetupInterface;
    use Sapphire\Database\DatabaseSetup;
    use PDO;

    class Database 
        implements SetupInterface {
        use DatabaseSetup;
            
        /**
         * @name $config
         * 
         * Contains database config from @/lock.json file
         */
        private \stdClass $config;

        /**
         * @name $connection
         * 
         * Contains database connection
         */
        public PDO $connection;

        public function __construct(\stdClass $config) {
            $this->config = $config;
            $this->Setup();
        }

        /**
         * @name GetTable
         * 
         * Returns DatabaseTable class instance that contains methods for easier querying
         */
        public function GetTable(string $name): DatabaseTable {
            return new DatabaseTable($this->connection, $name);
        }
    }