<?php
    namespace Sapphire\Collection;

    /**
     * This is multi-purpose class it can be used as information in Collection Schema
     *  or it can be information of Collection item
     * 
     * If it's information of Collection item then we use (null | string)
     * Else it's boolean (to check in admin which options should be included)
     */
    class CollectionSchemaInfo {
        public bool | null | int    $id;
        public bool | null | string $uuid;
        public bool | null | string $name;
        public bool | null | string $created_at;
        public bool | null | string $created_by;
        public bool | null | string $updated_at;
        public bool | null | string $updated_by;

        /**
         * @name BuildForSchema
         * @static
         * 
         * Builds CollectionSchemaInfo from $json for information of Schema
         */
        public static function BuildForSchema(\stdClass $json): CollectionSchemaInfo {
            $schema_info = new CollectionSchemaInfo;

            $schema_info->id = isset($json->id) ? $json->id : false;
            $schema_info->uuid = isset($json->uuid) ? $json->uuid : true;
            $schema_info->name = isset($json->name) ? $json->name : true;
            $schema_info->created_at = isset($json->created_at) ? $json->created_at : true;
            $schema_info->created_by = isset($json->created_by) ? $json->created_by : true;
            $schema_info->updated_at = isset($json->updated_at) ? $json->updated_at : true;
            $schema_info->updated_by = isset($json->updated_by) ? $json->updated_by : true;

            return $schema_info;
        }
    }