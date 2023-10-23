<?php
    namespace Sapphire\Router;

    trait RouterAdmin {
        private function CheckIfIsAdminPanel(): bool {
            $parts = $this->GetURLParts();

            return count($parts) === 0 ? false : strtolower($parts[1]) === "admin";
        }
    }