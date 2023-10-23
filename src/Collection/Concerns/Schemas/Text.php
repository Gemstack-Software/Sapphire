<?php
    namespace Sapphire\Collection\Concerns\Schemas;

    use Sapphire\Collection\Concerns\SchemaItem;

    class Text extends SchemaItem {
        public string                   $type = "Text";
        public array | string | null    $value = "";
    }