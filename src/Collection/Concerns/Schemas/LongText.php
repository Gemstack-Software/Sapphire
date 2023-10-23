<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class LongText extends Text {
        public string  $type = "LongText";
        public int     $max_size = 32768;
    }