<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class RichText extends Text {
        public string  $type = "RichText";
        public int     $max_size = 65536;
    }