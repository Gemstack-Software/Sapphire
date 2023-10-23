<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class IntNumber extends Number {
        public string  $type        = "IntNumber";
        public int     $max_size    = 2 ** 32;
    }