<?php
    namespace Sapphire\Component;

    trait ComponentEvents {
        /**
         * @name Mounted
         * 
         * This event is being triggered just before rendering component.
         * It should be used to fetch data to show in component
         */
        public function Mounted(): void {}   
    }