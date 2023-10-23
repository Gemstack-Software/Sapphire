<?php
    namespace Sapphire\Handle;
    use Sapphire\App\App;

    interface Handleable {
        /**
         * Handle some action that can be done with $app
         */
        public function Handle(App $app): void;
    }