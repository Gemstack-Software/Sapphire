<?php
    namespace Sapphire\App;

    use Sapphire\User\User;

    trait AppUser {
        /**
         * Returns current user
         */
        public function GetUser(): User {
            if(isset($this->user))
                return $this->user;

            return User::ById(0);
        }
    }