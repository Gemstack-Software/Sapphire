<?php
    namespace Sapphire\Collection;

    use Sapphire\Collection\Concerns\SchemaBuilder;
    use Sapphire\Json\Json;

    class CollectionSchema {
        // This properties are public to easier serialization (json)

        /**
         * Information about collection item ()
         */
        public CollectionSchemaInfo $info;

        /**
         * Contains all item's content
         */
        public \stdClass $content;

        /**
         * Contains all components
         */
        public \stdClass $components;

        public function __construct() {
            $this->info = CollectionSchemaInfo::BuildForSchema(Json::Empty());
        }

        /**
         * @name Raw
         * @static
         * 
         * Builds CollectionSchema from $json
         */
        public static function Raw(\stdClass $json): CollectionSchema {
            $schema = new CollectionSchema;

            $schema->info = @$json->info ? 
                CollectionSchemaInfo::BuildForSchema($json->info) :
                new CollectionSchemaInfo;

            $schema->content = $json->content ?? new \stdClass;
            $schema->components = $json->components ?? new \stdClass;

            return $schema;
        }
        
        /**
         * @name AddSchemaItem
         * 
         * Add class::SchemaItem<$type> named $name to schema
         * TODO: Check if schema item with this name exists
         */
        public function AddSchemaItem(string $name, string $type) {
            // Build schema item
            $schema_item = SchemaBuilder::Make($type);

            $this->content->{$name} = $schema_item;
        }

        /**
         * @name RemoveSchemaItem
         * 
         * Removes schema item with name: $name
         */
        public function RemoveSchemaItem(string $name) {
            unset($this->content->{$name});
        }

        /**
         * @name ChangeProperties
         * 
         * Changes the CollectionSchemaInfo properties
         */
        public function ChangeProperties(\stdClass $new_properties): void {
            $this->info = CollectionSchemaInfo::BuildForSchema($new_properties);
        }
    }