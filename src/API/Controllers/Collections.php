<?php
    namespace Sapphire\API\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Collection\Collection;
    use Sapphire\User\User;
    use Sapphire\Auth\Authenticator;

    class Collections {
        public array $url_map = [ 
            'all' => 'All', 
            'collection' => 'Collection',
            'create' => 'Create', 
            'delete-collection' => 'Delete',
            'add-schema-item' => 'AddSchemaItem',
            'remove-schema-item' => 'RemoveSchemaItem',
            'add-entry' => 'AddEntry',
            'remove-entry' => 'RemoveEntry',
            'edit-entry' => 'EditEntry',
            'change-allowed-properties' => 'ChangeAllowedProperties'
        ];

        /**
         * @name All
         * 
         * Returns all collections as an array
         */
        public function All(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $collections = [];

            $collections_path_agent = new PathConstructor("@/resources/collections");
            $collections_path = $collections_path_agent->GetReal();
            $collections_folder = new File($collections_path);

            foreach($collections_folder->NotSecretFiles() as $collection_file) {
                $collection_path_agent = new PathConstructor("@/resources/collections/$collection_file");
                $collection = new File($collection_path_agent->GetReal());

                $collections[] = Collection::File($collection);
            }

            return [
                "status" => 200,
                "message" => "Successfully got collections",
                "content" => $collections
            ];
        }

        /**
         * @name Collection
         * 
         * Returns collection as an array
         */
        public function Collection(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $collection_name = $request->GetParamByIndex(0);

            return [
                "status" => 200,
                "message" => "Successfully got collection",
                "content" => Collection::GetByFilename($collection_name)
            ];
        }

        /**
         * @name Create
         * 
         * Creates a new empty collection with name: $name
         * TODO: Check if collection with this name exists
         */
        public function Create(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];

            $data = $request->GetContent();
            $name = $data->name;

            $collection = Collection::Make($name);
            $collection->Save();

            return [
                "status" => 200,
                "message" => "Successfully created collection",
                "content" => [ "collection" => $collection->Serialize() ]
            ];
        }

        /**
         * @name Delete
         * 
         * Moves collection to trash (inside trash it can be totally deleted).
         * This action is undo(able) to prevent situations like: DROP DATABASE `prod` BY MISTAKE
         */
        public function Delete(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];

            $data = $request->GetContent();
            $name = $data->name;

            $trash_identifier = uniqid();

            $previous_path_agent    = new PathConstructor("@/resources/collections/$name.json");
            $next_path_agent        = new PathConstructor("@/resources/~trash/collections/$name-$trash_identifier.json"); 

            File::RenameFile($previous_path_agent->GetReal(), $next_path_agent->GetReal());

            return [
                "status" => 200,
                "message" => "Successfully deleted collection",
                "content" => null
            ];
        }

        /**
         * @name AddSchemaItem
         * 
         * Creates new schema item (part of schema) and saves it inside collection
         * TODO: Check if schema item with this name exists
         */
        public function AddSchemaItem(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];

            $data = $request->GetContent();

            $collection_name = $data->collection;
            $name = $data->name;
            $type = $data->type;

            $collection = Collection::GetByFilename($collection_name);

            $collection->schema->AddSchemaItem($name, $type);            
            $collection->Save();

            return [
                "status" => 200,
                "message" => "Collection saved successfully",
                "content" => $collection
            ];
        }

        /**
         * @name RemoveSchemaItem
         * 
         * Removes schema item (part of schema) and saves it to collection
         */
        public function RemoveSchemaItem(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];

            $data = $request->GetContent();

            $collection_name = $data->collection;
            $name = $data->item;

            $collection = Collection::GetByFilename($collection_name);

            $collection->schema->RemoveSchemaItem($name);            
            $collection->Save();

            return [
                "status" => 200,
                "message" => "Collection saved successfully",
                "content" => $collection
            ];
        }

        /**
         * @name AddEntry
         * 
         * Add new entry to collection with content = collection.schema filled with data passed by user
         */
        public function AddEntry(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();

            $filled_data = $data->data;
            $collection_id = $data->collection_id;
            $entry_name = $data->name;

            // Getting required data
            $user = $app->GetUser();
            $collection = Collection::GetByFilename($collection_id);
             
            // Making an entry
            $entry = $collection->MakeEntry($entry_name, $filled_data, $user);

            $collection->Insert($entry);
            $collection->Save();

            return [
                "status" => 200,
                "message" => "Entry created successfully",
                "content" => $collection
            ];
        }

        /**
         * @name RemoveEntry
         * 
         * Removes collection data entry
         */
        public function RemoveEntry(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();

            $entry = $data->entry;
            $collection_id = $data->id;

            // Getting required data
            $user = $app->GetUser();
            $collection = Collection::GetByFilename($collection_id);
             
            // Removing entry
            $collection->DeleteEntry(
                uuid: $entry->uuid ?? null, 
                id: $entry-> id ?? null
            );
            $collection->Save();
 
            return [
                "status" => 200,
                "message" => "Entry removed successfully",
                "content" => $collection
            ];
        }

        /**
         * @name EditEntry
         * 
         * Edits entry data
         */
        public function EditEntry(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();

            $entry = $data->entry;
            $collection_id = $data->id;

            // Getting required data
            $user = $app->GetUser();
            $collection = Collection::GetByFilename($collection_id);

            // Removing entry
            $collection->EditEntry(
                uuid: $entry->uuid ?? null, 
                id: $entry-> id ?? null,
                attributes: $entry->attributes
            );
            $collection->Save();
 
            return [
                "status" => 200,
                "message" => "Entry edited successfull!y",
                "content" => $collection
            ];
        }

        /**
         * @name ChangeAllowedProperties
         * 
         * Changes the properties that are allowed to collect (id, uuid, name, created_at, created_by, updated_at, updated_by)
         */
        public function ChangeAllowedProperties(Request $request, App $app): array {       
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];

            $data = $request->GetContent();

            $properties = $data->properties;
            $collection_id = $data->collection_id;
            $collection = Collection::GetByFilename($collection_id);

            if(!$collection->IsEmpty()) return [ 
                "status" => 400, 
                "message" => "Failed to change allowed properties of not empty collection", 
                "content" => null 
            ];

            $collection->schema->ChangeProperties($properties);
            $collection->Save();

            return [
                "status" => 200,
                "message" => "Collection allowed properties were successfully changed",
                "content" => $collection 
            ];
        }
    }