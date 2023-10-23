<?php
    namespace Sapphire\Farbic;

    interface Fabricable {
        /**
         * @name Make
         * @static
         * 
         * Fabricates new class instance using provided $args
         */
        public static function Make(\any ...$args): \any;
    }