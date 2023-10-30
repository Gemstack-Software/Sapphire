<?php
    namespace Sapphire\Page;

    trait PageProperties {
        public function Properties(): array {
            return static::GetProperties($this->GetId());
        }
    }