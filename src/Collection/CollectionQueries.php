<?php
    namespace Sapphire\Collection;
    
    /**
     * @trait CollectionQueries
     * 
     * WARNING: Entries are returned as \stdClass because entries can have multiple forms and creating class for CollectionEntry is useless.
     * WARNING: Methods in this trait DO NOT auto-save to file! 
     */
    trait CollectionQueries {
        /**
         * @name DeleteEntry
         * 
         * Deletes an entry from collection content by it's uuid or id
         */
        public function DeleteEntry(string|null $id = null, string|null $uuid = null): void {
            $new_entries = [];

            // If id is passed then we use Id to identify
            $identify_by_id = !!$id;

            foreach($this->contents as $entry_item) {
                if($identify_by_id) {
                    if($entry_item->id !== $id) $new_entries[] = $entry_item;
                }
                else {
                    if($entry_item->uuid !== $uuid) $new_entries[] = $entry_item;
                }
            }

            // Reset the content
            $this->contents = $new_entries;
        }

        /**
         * @name GetEntryAndEntryIndexById
         * 
         * Returns a collection entry which id: $id and it's index in array
         */
        public function GetEntryAndEntryIndexById(string $id): array {
            foreach($this->contents as $key => $entry_item) {
                if($entry_item->id == $id) return [$entry_item, $key];
            }

            return [null, null];
        }

        /**
         * @name GetEntryAndEntryIndexByUuid
         * 
         * Returns a collection entry which uuid: $uuid and it's index in array
         */
        public function GetEntryAndEntryIndexByUuid(string $uuid): array {
            foreach($this->contents as $key => $entry_item) {
                if($entry_item->uuid === $uuid) return [$entry_item, $key];
            }

            return [null, null];
        }

        /**
         * @name EditEntry
         * 
         * Changes entry attributes by id or uuid
         * Requires passing $attributes to change
         * 
         * TODO: Updated by and updated at
         */
        public function EditEntry(string|null $id = null, string|null $uuid = null, $attributes = null): void {
            if(!$attributes) return;

            // Get entry if it does not exists then return
            [$entry, $entry_index] = $id ? $this->GetEntryAndEntryIndexById($id) : $this->GetEntryAndEntryIndexByUuid($uuid);
            if(!$entry) return;

            // Changing attributes
            $entry->attributes = $attributes;

            // Updating updated_by and updated_at
            $entry->updated_at = date('Y-m-d H:i:s');
            $entry->updated_by = $_SESSION["sapphire_user_id"];

            // Replace entry
            $this->contents[$entry_index] = $entry;
        }

        /**
         * @name Insert
         * 
         * Inserts new data entry into the collection
         */
        public function Insert($entry): void {
            $this->contents[] = $entry;
        }

        /**
         * @name CountRecords
         * 
         * Returns the count of data records in collection
         */
        public function CountRecords(): int {
            return count($this->contents);
        }

        /**
         * @name IsEmpty
         *  
         * Returns true if collection is empty
         */
        public function IsEmpty(): bool {
            return $this->CountRecords() === 0;
        }

        /**
         * @name Entry
         * 
         * Returns entry by it's name
         */
        public function Entry(string $name) {
            foreach($this->contents as $key => $entry_item) {
                if($entry_item->name === $name) return $entry_item;
            }

            return null;
        }

        /**
         * @name All
         * 
         * Returns an array of entries
         */
        public function All(): array {
            return $this->contents;
        }
    }