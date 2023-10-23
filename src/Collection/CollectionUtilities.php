<?php
    namespace Sapphire\Collection;

    trait CollectionUtilities {
        /**
         * Returns index of last entry in collection (entry.id) | ID
         * 
         * If "id" is disabled in collection then returns 0
         * If collection is empty then returns 0
         */
        public function LastEntryIndex(): int {
            // Check if collection is empty
            if(empty($this->contents)) return 0;
            
            // Get the entry
            $entry = $this->contents[count($this->contents) - 1];

            return $entry->id ?? 0;
        }
    }