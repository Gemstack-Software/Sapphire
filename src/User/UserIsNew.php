<?php
    namespace Sapphire\User;

    trait UserIsNew {
        /**
         * Checks if user is new
         */
        public function IsNew(): bool {
            ///////////////////////////////////////////////////
            // Guest user cannot be new because it's not user
            ///////////////////////////////////////////////////
            if($this->GetRole() === "Guest") return false;

            ///////////////////////////////////////////////////
            // User which not exists cannot be new
            ///////////////////////////////////////////////////
            if(!$this->Exists()) return false;

            return $this->is_new;
        }
    }