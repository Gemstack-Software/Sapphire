<?php
    namespace Sapphire\Collection\Concerns\Schemas;
    
    use Sapphire\Collection\Concerns\SchemaItem;

    class VideoCollection extends SchemaItem {
        public string  $type        = "VideoCollection";
        public int     $max_size    = 1000000;

        public function MakeValue(): \any {
            return !is_array($this->value) ? [$this->value] : $this->value;
        }
    }