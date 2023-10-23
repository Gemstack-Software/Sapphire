<?php
    namespace Sapphire\Router;

    trait RouterAuth {
        public function CheckIfIsAuth(): bool {
            if(!$this->is_admin_panel) return false;

            $parts = $this->GetURLParts();
            if(count($parts) < 3) return false;

            return $parts[2] === "login";
        }
    }