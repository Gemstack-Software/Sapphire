<?php
    namespace Sapphire\Collection\Concerns\Schemas;
    use Sapphire\Collection\Concerns\SchemaItem;

    class MixedArray extends SchemaItem {

        public string                   $type = "MixedArray";
        public array | string | null    $value = [];
        public int                      $max_size = 2 ** 32;

        /**
         * Fabricates value (for numbers e.g. intval() or floatval())
         */
        public function MakeValue(): \any {
            return $this->value;
        }
    }