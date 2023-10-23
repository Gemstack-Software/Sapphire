<?php
    namespace Sapphire\Collection;

    use Sapphire\File\File;
    use Sapphire\Collection\Collection;
    use Sapphire\Collection\CollectionInfo;
    use Sapphire\Path\PathConstructor;


    trait CollectionFactory {
        /**
         * @name File
         * @static
         * 
         * Constructs Collection class from File class (from file buffer)
         */
        public static function File(File $file): Collection {
            $raw_json = $file->Json();
            // Building the collection
            $collection = new Collection();
            
            $collection->SetInfo(
                CollectionInfo::Raw($raw_json->collection->info)
            );

            $collection->SetSchema(
                CollectionSchema::Raw($raw_json->collection->schema)
            );

            $collection->SetContents(
                $raw_json->collection->contents
            );

            return $collection;
        }

        /**
         * @name Make
         * @static
         * 
         * Fabricates new collection
         */
        public static function Make(string $name): Collection {
            $collection = new Collection();
            $info = new CollectionInfo;

            $info->SetId($name);
            $info->SetUuid(uniqid('sapphire-'));
            $info->SetDisplayName($name);
            $info->SetSingleName($name);

            $collection->SetInfo(
                $info
            );

            $collection->SetSchema(
                new CollectionSchema
            );

            $collection->SetContents(
                []
            );

            return $collection;
        } 

        /**
         * @name GetByName
         * @static
         * 
         * Returns Collection or null depends if this collection exists
         * PROTIP: Collection.info.id is a constant value (identifier) that is always same as collection filename (without .json)
         */
        public static function GetByFilename(string $name): Collection | null {
            $path_agent = new PathConstructor("@resources/collections/$name.json");
            $path = $path_agent->GetReal();

            $file = new File($path);
            if(!$file->Exists()) return null;

            return static::File($file);
        }
    }