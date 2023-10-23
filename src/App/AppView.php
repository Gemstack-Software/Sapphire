<?php
    namespace Sapphire\App;

    use Sapphire\View\View;

    trait AppView {
        /**
         * Shows view with name: $name
         */
        public function View(string $name, array $data = [], string $root_folder = "@/resources/views/"): void {
            View::View($name, $data, $root_folder);
        }
    }