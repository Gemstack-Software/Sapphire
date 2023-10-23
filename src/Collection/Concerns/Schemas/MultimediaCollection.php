<?php
    namespace Sapphire\Collection\Concerns\Schemas;
    
    use Sapphire\Collection\Concerns\SchemaItem;

    class MultimediaCollection extends SchemaItem {
        public string  $type        = "MultimediaCollection";
        public int     $max_size    = 1000000;

        public function MakeValue(): \any {
            return !is_array($this->value) ? [$this->value] : $this->value;
        }
    }