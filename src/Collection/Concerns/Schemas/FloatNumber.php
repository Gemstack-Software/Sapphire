<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    class FloatNumber extends Number {
        public string  $type        = "FloatNumber";
        public int     $max_size    = 2 ** 32;

        public function MakeValue(): \any {
            $value = $this->value;

            if(!$value) 
                return 0;

            if(is_array($value)) 
                return count($value) > 0 ? floatval($value[0]) : 0;

            return floatval($value);
        }
    }