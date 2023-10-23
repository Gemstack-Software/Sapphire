<?php
    namespace Sapphire\App;

    use Sapphire\User\User;

    trait AppUser {
        /**
         * Returns current user
         */
        public function GetUser(): User {
            return $this->user;
        }
    }