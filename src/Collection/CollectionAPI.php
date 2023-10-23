<?php
    namespace Sapphire\Collection;

    use Sapphire\Collection\Collection;

    /**
     * API For using Collections
     */
    trait CollectionAPI {
        public static function Get(string $collection_name): Collection | null {
            return Collection::GetByFilename($collection_name);
        }
    }