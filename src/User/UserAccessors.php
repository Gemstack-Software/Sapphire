<?php
    namespace Sapphire\User;

    trait UserAccessors {
        public function GetId(): int {
            return $this->id;
        }

        public function GetUsername(): string {
            return $this->username;
        }

        public function GetEmail(): string {
            return $this->email;
        }

        public function GetRole(): string {
            if(isset($this->role))
                return $this->role;
    
            return "Guest";
        }

        public function GetCreatedAt(): string {
            return $this->created_at;
        }

        public function IsGuest(): bool {
            return $this->id === -1;
        }

        public function GetAvatar(): string {
            return "/assets/sapphire.png";
        }

        /**
         * Serialize object as json
         */
        public function AsJSONString(): string {
            return json_encode($this->Serialize());
        }

        /**
         * Serialize object as array
         */
        public function Serialize(): array {
            return [
                "id" => $this->GetId(),
                "username" => $this->GetUsername(),
                "email" => $this->GetEmail(),
                "role" => $this->GetRole(),
                "created_at" => $this->GetCreatedAt(),
                "is_guest" => $this->IsGuest()
            ];
        }
    
        /**
         * Outputs user as string (echo to html)
         */
        public function Out(): void {
            echo htmlspecialchars($this->AsJSONString());
        }

        /**
         * Returns if user exists
         */
        public function Exists(): bool {
            return $this->exists;
        }
    }