<?php
    namespace Sapphire\Router;

    trait RouterUtils {
        private function GetURLParts(): array {
            return explode("/", $this->request_path);
        }
    }