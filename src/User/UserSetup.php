<?php
    namespace Sapphire\User;

    use Sapphire\Setup\SetupInterface;

    trait UserSetup {
        public function Setup(): void {
            $this->id === -1 ? $this->SetupGuestUser() : $this->SetupActualUser();
        }

        /**
         * @name SetupGuestUser
         * 
         * Setup unlogged user (client)
         */
        private function SetupGuestUser(): void {
            $this->username = "Guest";
            $this->email = "unknown@sapphire.faciosoft.com";
            $this->role = "Guest";
            $this->created_at = date("Y.m.d");
        }

        /**
         * @name SetupActualUser
         * 
         * Setup logged user (admin or mod or owner)
         */
        private function SetupActualUser(): void {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');
            
            $user = $table->Where([
                ["id", "=", $this->id]
            ]);

            if(!$user) {
                $this->exists = false;
                return;
            }

            $this->username = $user->username;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->created_at = $user->created_at;

            ///////////////////////////////////////////////////
            // Checks if user has no password set (user is new)
            ///////////////////////////////////////////////////
            $this->is_new = $user->password === hash('sha256', '');
        }
    }