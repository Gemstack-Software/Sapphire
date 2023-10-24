<?php
    namespace Sapphire\User;

    trait UserRoles {
        public function IsSuperAdmin(): bool {
            return $this->GetRole() === 'Super Admin';
        }

        public function IsAdmin(): bool {
            return $this->GetRole() === 'Admin';
        }

        public function IsModerator(): bool {
            return $this->GetRole() === 'Moderator';
        }
    }