<?php
    namespace Sapphire\Collection\Concerns;

    use Sapphire\Serialize\Serialize;

    class SchemaItem {
        use Serialize;

        public string                   $type;
        public array | string | null    $value;
        public int                      $max_size;

        /**
         * Fabricates value (for numbers e.g. intval() or floatval())
         */
        public function MakeValue(): \any {
            return $this->value;
        }
    }