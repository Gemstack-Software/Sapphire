<?php
    namespace Sapphire\User;

    use Sapphire\User\User;

    /**
     * Part of User getters (ByCredentail, Session, ByLogin) are in UserAuth because they are auth getters
     */
    trait UserGetters {
        /**
         * @name ById
         * @static
         * 
         * Returns user by id
         */
        public static function ById(int $id): User | null {
            return new User($id);
        }

        /**
         * @name All
         * @static
         * 
         * Returns all users
         */
        public static function All(): array {
            global $app;

            ////////////////////////////////
            // Get database and table
            ////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            ////////////////////////////////
            // Get users from db
            ////////////////////////////////
            $db_users = $table->AllWhere([
                ["id", ">", 0]
            ]);
            
            ////////////////////////////////
            // Format users
            ////////////////////////////////
            $users = [];

            foreach($db_users as $db_user)
                $users[] = static::ById($db_user->id)->Serialize();

            /////////////////////////////////
            // Return users
            /////////////////////////////////
            return $users;
        }
    }