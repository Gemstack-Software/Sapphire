<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\File\UploadableFile;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Auth\Authenticator;

    class Assets {
        public array $url_map = [ 
            'all'                   => 'All',
            'filter-by-extension'   => 'FilterByExtension',
            'upload'                => 'Upload',
            'rename'                => 'Rename',
            'delete'                => 'Delete',
        ];

        /**
         * @name All
         * 
         * Returns all assets from database
         */
        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            $assets = $table->AllWhere([
                ["id", ">", "0"]
            ]);

            return [
                "status"  => 200,
                "message" => "Successfully fetched assets",
                "content" => $assets ? $assets : []
            ];
        }

         /**
         * @name FilterByExtension
         * 
         * Returns all assets which has extension that in $request->extensions array
         */
        public function FilterByExtension(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();
            $extensions = $data->extensions;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            $all_assets = [];
            foreach($extensions as $extension) {
                $assets = $table->Like([
                    ["filename", "/assets/uploads/asset-%.$extension"]
                ]);

                $all_assets = [ ...$assets, ...$all_assets ];
            }

            return [
                "status"  => 200,
                "message" => "Successfully fetched assets by extension",
                "content" => [ ... $all_assets ] // $all_assets ? $all_assets : []
            ];
        }

        /**
         * @name Upload
         * 
         * Uploads asset to server
         */
        public function Upload(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $user = $app->GetUser();
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');
            $upload_date = date('Y-m-d H:i:s');

            // Getting the file and the extension (passed using FormData in js)
            $file = $request->File('file');
            $file_extension = $file->GetExtension();

            if(! UploadableFile::ValidExtension($file_extension)) return [
                "status" => 400,
                "message" => "File has .$file_extension extension which is not allowed!"
            ];

            // Making new filename inside /public/assets/uploads
            $file_name = uniqid('asset-') . '.' . $file_extension;

            $path_agent = new PathConstructor("@/public/assets/uploads/$file_name");
            $file_path = $path_agent->GetReal();

            // Move uploaded file to /public/assets/uploads
            $file->Move($file_path);

            // Insert to database the asset metainfo
            $table->Insert([
                NULL,
                "Asset $upload_date",
                "/assets/uploads/$file_name",
                $user->GetId(),
                $upload_date
            ]);

            return [
                "status" => 200,
                "message" => "Successfully uploaded new asset",
                "content" => null
            ];
        }

        /**
         * @name Rename
         * 
         * Renames the label of asset
         */
        public function Rename(Request $request, App $app): array {   
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();
            $asset_id = $data->asset_id;
            $label = $data->label;

            // Getting database handlers
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            // Updates table
            $table->UpdateSingle([
                "label" => $label
            ], whereId: $asset_id);

            return [
                "status" => 200,
                "message" => "Successfully renamed asset",
                "content" => null
            ];
        }

        /**
         * @name Delete
         * 
         * Delete the asset
         */
        public function Delete(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];

            $data = $request->GetContent();
            $asset_id = $data->asset_id;

            // Getting database handlers
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            // Get asset from database
            $asset = $table->Where([
                ['id', '=', $asset_id]
            ]);

            // Updates table
            $table->DeleteSingle(whereId: $asset_id);

            // Delete asset file
            $path_agent = new PathConstructor("@/public/$asset->filename");
            $file = new File($path_agent->GetReal());
            $file->Delete();

            return [
                "status" => 200,
                "message" => "Successfully delete asset",
                "content" => null
            ];
        }
    }