<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class ShortText extends Text {
        public string  $type = "ShortText";
        public int     $max_size = 512;
    }