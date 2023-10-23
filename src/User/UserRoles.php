<?php
    namespace Sapphire\User;

    trait UserRoles {
        public function IsSuperAdmin(): bool {
            return $this->role === 'Super Admin';
        }

        public function IsAdmin(): bool {
            return $this->role === 'Admin';
        }

        public function IsModerator(): bool {
            return $this->role === 'Moderator';
        }
    }