<?php
    namespace Sapphire\Styles;

    trait StyleScoper { 
        private string $component_hash;
        private bool $scoped = false;

        /**
         * Setting if style is scoped to component
         */
        public function SetScoped(bool $is_scoped, string $component_hash): void {
            $this->scoped = $is_scoped;
            $this->component_hash = $component_hash;
        }

        /**
         * Adding scope to styles at all (@)
         */
        public function ScopeCss(string $css): string {
            return str_replace(
                "@", 
                "[hash=\"$this->component_hash\"]", 
                $css
            );
        }
    }