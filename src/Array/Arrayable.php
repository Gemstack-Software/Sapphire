<?php
    namespace Sapphire\Array;

    interface Arrayable {
        /**
         * @name toArray
         * 
         * Returns class data (properties) as array to be serialized
         */
        public function ToArray(): array;
    }