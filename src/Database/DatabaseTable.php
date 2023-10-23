<?php
    namespace Sapphire\Database;

    use PDO;
    use PDOException;
    use Sapphire\Json\Json;

    /**
     * TODO: Make queries secure (htmlspecialchars database escape etc)
     */
    class DatabaseTable {
        private string $name;
        private PDO $connection;

        public function __construct(PDO $connection, string $name) {
            $this->connection = $connection;
            $this->name = $name;
        }


        /**
         * @name Exists
         * 
         * Check if database table `$this->name` exists
         */
        public function Exists(): bool {
            try {
                $this->connection->query("DESCRIBE `$this->name`");
                return true;
            }
            catch(PDOException $e) {
                return false;
            }

            return false;
        }

        /**
         * @name Where
         * 
         * Returns single row which fit the $conditions connected using $connect (AND | OR)
         */
        public function Where(array $conditions, string $connect = "AND"): \stdClass | array | bool {
            $query = "SELECT * FROM `$this->name`";

            // Add conditions
            if(count($conditions) > 0) $query .= " WHERE ";

            foreach($conditions as $key => $condition) {
                if($key !== 0) $query .= " $connect ";

                $condition_name = $condition[0];
                $condition_operator = $condition[1];
                $condition_value = $condition[2];

                $query .= "`$condition_name`$condition_operator'$condition_value' ";
            }

            $stmt = $this->connection->query($query);
            $results = $stmt->fetch();

            return Json::Make($results);
        }

        /**
         * @name AllWhere
         * 
         * Returns all rows which fit the $conditions connected using $connect (AND | OR)
         */
        public function AllWhere(array $conditions, string $connect = "AND"): \stdClass | array | bool {
            $query = "SELECT * FROM `$this->name`";

            // Add conditions
            if(count($conditions) > 0) $query .= " WHERE ";

            foreach($conditions as $key => $condition) {
                if($key !== 0) $query .= " $connect ";

                $condition_name = $condition[0];
                $condition_operator = $condition[1];
                $condition_value = $condition[2];

                $query .= "`$condition_name`$condition_operator'$condition_value' ";
            }

            $stmt = $this->connection->query($query);
            $results = $stmt->fetchAll();

            return Json::ToArray($results);
        }

        /**
         * @name HasAnyRecord
         * 
         * Returns if table has any record
         */
        public function HasAnyRecord(): bool {
            $query = "SELECT * FROM `$this->name` LIMIT 1";

            $stmt = $this->connection->query($query);
            $results = $stmt->fetch();

            return !!$results;
        }

        /**
         * @name Insert
         * 
         * Inserts data which is in $data array into the database table
         */
        public function Insert(array $data): void {
            $query = "INSERT INTO `$this->name` VALUES (";

            foreach($data as $key => $value) {
                $query .= "'$value'" . ($key !== count($data) - 1 ? ', ' : '');
            }

            $query .= ");";

            $stmt = $this->connection->query($query);
            $results = $stmt->fetch();  
        }

        /**
         * @name UpdateSingleById
         * 
         * Updates single data record where id = $id
         */
        public function UpdateSingleById(array $updates, string $id): void {
            $query = "UPDATE `$this->name` SET ";

            // Add updates to query
            $index = 0;
            $count = count($updates);
            foreach($updates as $row_name => $row_value) 
                $query .= "`$row_name`='$row_value'" . ((++$index != $count) ? ',' : '');

            // End up the query
            $query .= " WHERE `id` = '$id'";

            // Send the query
            $stmt = $this->connection->query($query);
            $results = $stmt->fetch();
        }

        /**
         * @name UpdateSingle
         * 
         * Updates single data record in database table
         */
        public function UpdateSingle(
            array $updates, 
            int|string|null $whereId = null
            ): void {

            if($whereId) $this->UpdateSingleById($updates, "$whereId");
            
        }

        /**
         * @name DeleteSingleById
         * 
         * Delete single data record from database table
         */
        public function DeleteSingleById(string $whereId): void {
            $query = "DELETE FROM `$this->name` WHERE `id`='$whereId'";

            $stmt = $this->connection->query($query);
            $stmt->fetch();
        }

        /**
         * @name DeleteSingle
         * 
         * Delete single data record in database table
         */
        public function DeleteSingle(
            int|string|null $whereId = null
            ): void {

            if($whereId) $this->DeleteSingleById("$whereId");
            
        }

        /**
         * @name Like
         * 
         * Return database records that match conditions
         */
        public function Like(array $conditions, string $connect = 'AND'): \stdClass | array | bool {
            $query = "SELECT * FROM `$this->name` WHERE ";

            foreach($conditions as $key => $condition) {
                if($key !== 0) $query .= " $connect ";

                $condition_column = $condition[0];
                $condition_like = $condition[1];

                $query .= "`$condition_column` LIKE '$condition_like' ";
            }

            $stmt = $this->connection->query($query);
            $results = $stmt->fetchAll();

            return Json::ToArray($results);
        }

        /**
         * @name UpdateAll
         * 
         * Updates all row in database
         */
        public function UpdateAll(array $updates): void {
            $query = "UPDATE `$this->name` SET ";

            // Add updates to query
            $index = 0;
            $count = count($updates);
            foreach($updates as $row_name => $row_value) 
                $query .= "`$row_name`='$row_value'" . ((++$index != $count) ? ',' : '');


            // Send the query
            $stmt = $this->connection->query($query);
            $results = $stmt->fetch();
        }
    }