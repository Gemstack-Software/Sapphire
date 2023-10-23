<?php
    namespace Sapphire\Plugin;

    trait PluginApp {
        /**
         * Returns app instance
         */
        public function GetApp() {
            global $app;

            return $app;
        }
    }