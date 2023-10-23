<?php
    namespace Sapphire\User;

    use Sapphire\User\User;
    use Sapphire\Setup\SetupInterface;

    trait UserAuth {
        /**
         * @name HasSession
         * @static
         * 
         * Checks if user is logged
         */
        public static function HasSession(): bool {
            return $_SESSION && array_key_exists("sapphire_user_logged", $_SESSION);
        }

        /**
         * @name SessionId
         * @static
         * 
         * Returns user id whose session is logged
         */
        public static function SessionId(): int {
            if(!User::HasSession()) return -1; // Not logged code (-1)

            return array_key_exists("sapphire_user_id", $_SESSION) ? intval($_SESSION["sapphire_user_id"]) : -1;
        } 

        /**
         * @name Session
         * @static
         * 
         * Returns current session's user or unknown user (unlogged)
         */
        public static function Session(): User {
            return new User(User::SessionId());
        }

        /**
         * @name ByCredential
         * @static
         * 
         * Returns user by credential (username or email)
         */
        public static function ByCredential(string $credential): User | null {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            $user = $table->Where([
                ['username', '=', $credential],
                ['email', '=', $credential]
            ], 'OR');

            return !$user ? null : new User($user->id);
        }

        /**
         * @name ByLogin
         * @static
         * 
         * Returns user by login credentials (username and password)
         */
        public static function ByLogin(string $username, string $password): User | null {
            global $app;

            $password_hashed = hash('sha256', $password);

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            $user = $table->Where([
                ['username', '=', $username],
                ['password', '=', $password_hashed]
            ]);

            return !$user ? null : new User($user->id);
        }
    }