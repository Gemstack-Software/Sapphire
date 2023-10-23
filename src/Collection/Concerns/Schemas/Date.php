<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class Date extends Text {
        public string  $type = "Date";
        public int     $max_size = 32;
    }