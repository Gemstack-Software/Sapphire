<?php
    namespace Sapphire\View;

    interface Viewable {
        /**
         * Method that includes view (using View class) it can be used example in App class
         */
        public function View(string $name, array $data = []): void;
    }