<?php
    namespace Sapphire\Collection;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Exceptions\CollectionFileNotFoundException;

    trait CollectionSaver {
        /**
         * @name Save
         * 
         * Saves the collection data to collection file
         */
        public function Save(): void {
            // Serialize our collection
            $serialized = [ "collection" => $this->Serialize() ];

            // Get the filename of collection which is equivalent to (const string) Collection->info->id
            $filename = $this->info->id;

            // Get the collection file
            $collection_path_agent = new PathConstructor("@/resources/collections/$filename.json");
            $collection_file = new File($collection_path_agent->GetReal());

            // Save collection content
            $collection_file->Json($serialized);
        }
    }