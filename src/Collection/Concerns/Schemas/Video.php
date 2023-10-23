<?php
    namespace Sapphire\Collection\Concerns\Schemas;
    
    use Sapphire\Collection\Concerns\SchemaItem;

    class Video extends SchemaItem {
        public string  $type        = "Video";
        public int     $max_size    = 1;

        public function MakeValue(): \any {
            if(is_array($this->value)) {
                return count($this->value) > 0 ? $this->value[0] : null;
            }

            return $this->value;
        }
    }