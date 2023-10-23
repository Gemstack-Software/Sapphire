<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    use Sapphire\Collection\Concerns\SchemaItem;

    class Number extends SchemaItem {
        public string                   $type = "Number";
        public array | string | null    $value = "";

        public function MakeValue(): \any {
            $value = $this->value;

            if(!$value) 
                return 0;

            if(is_array($value)) 
                return count($value) > 0 ? intval($value[0]) : 0;

            return intval($value);
        }
    }