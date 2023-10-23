<?php
    namespace Sapphire\Collection;

    class CollectionInfo {
        // This properties are public to easier serialization (json)
        public string $uuid;
        public string $id;
        public string $display_name;
        public string $single_name;

        public function SetUuid(string $uuid): void {
            $this->uuid = $uuid;
        }

        public function SetId(string $id): void {
            $this->id = $id;
        }

        public function SetDisplayName(string $display_name): void {
            $this->display_name = $display_name;
        }

        public function SetSingleName(string $single_name): void {
            $this->single_name = $single_name;
        }

        /**
         * @name Raw
         * @static
         * 
         * Builds CollectionInfo from $json
         */
        public static function Raw(\stdClass $json): CollectionInfo {
            $info = new CollectionInfo;

            $info->SetUuid($json->uuid);
            $info->SetId($json->id);
            $info->SetDisplayName($json->display_name);
            $info->SetSingleName($json->single_name);
        
            return $info;
        }
    }