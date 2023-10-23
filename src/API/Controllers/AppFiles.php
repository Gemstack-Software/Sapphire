<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\File\UploadableFile;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Json\Json;
    use Sapphire\Auth\Authenticator;

    /**
     * 
     * WARNING
     * ================================================
     *
     * Description of folder
     * Inner folder - the folder of single e.g. Layout or Component
     * Outer folder (folder) - the folder containing multiple Inner folders
     */
    class AppFiles {
        public array $url_map = [ 
            'folder' => 'Folder',
            'inner-folder' => 'InnerFolder',
            'file' => 'File',
            'save' => 'Save',
            'add' => 'Add'
        ];

        /**
         * @name Folder
         * 
         * Returns folder files from app to edit (The outer folder)
         */
        public function Folder(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];
            $folder_name   = $request->GetParamByIndex(0); 

            // Check if folder is not legal
            if(!in_array($folder_name, AppFiles::LegalFolders())) return [
                "status" => 403,
                "message" => "Folder $folder_name is prohibited!",
                "content" => []
            ];

            // Get folder path
            $path_agent = new PathConstructor("@resources/$folder_name");
            $path = $path_agent->GetReal();
            $folder = new File($path);

            // Getting folder files (recursive) (folder: **/*)
            $folder_folders = $folder->NotSecretFilesProceed();
            $parsed_folders = [];

            foreach($folder_folders as $inner_folder) {
                $parsed_folders[] = Json::Make([
                    "name"  => $inner_folder->GetFilename(),
                    "files" => $inner_folder->Files()
                ]);
            }
            
            return [
                "status"  => 200,
                "message" => "Successfully fetched files",
                "content" => $parsed_folders
            ];
        }

        /**
         * @name InnerFolder
         * 
         * Returns inner folder from folder
         */
        public function InnerFolder(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];
            $outer_name   = $request->GetParamByIndex(0); 
            $inner_name   = $request->GetParamByIndex(1);

            // Check if folder is not legal
            if(!in_array($outer_name, AppFiles::LegalFolders())) return [
                "status" => 403,
                "message" => "Folder $outer_name is prohibited!",
                "content" => []
            ];

            // Get folder path
            $path_agent = new PathConstructor("@resources/$outer_name/$inner_name");
            $path = $path_agent->GetReal();
            $folder = new File($path);

            // Returning it's content
            return [
                "status"  => 200,
                "message" => "Successfully fetched files",
                "content" => $folder->Files()
            ];
        }

        /**
         * @name File 
         * 
         * Return file content
         */
        public function File(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];
            $data = $request->GetContent();

            $filename = $data->filename;
            $inner = $data->inner_folder;
            $outer = $data->outer_folder;

            // Check if folder is not legal
            if(!in_array($outer, AppFiles::LegalFolders())) return [
                "status" => 403,
                "message" => "Folder $outer is prohibited!",
                "content" => []
            ];

            // Getting file
            $path_agent = new PathConstructor("@resources/$outer/$inner/$filename");
            $path = $path_agent->GetReal();
            $file = new File($path);

            // Returning it's content
            return [
                "status"  => 200,
                "message" => "Successfully fetched file",
                "content" => $file->Read()
            ];
        }

        /**
         * @name Save 
         * 
         * Saving file
         */
        public function Save(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];
            $data = $request->GetContent();

            $file = $data->file;
            $content = $data->content;
            $outer = $data->outer_folder;
            $inner = $data->inner_folder;

            // Check if folder is not legal
            if(!in_array($outer, AppFiles::LegalFolders())) return [
                "status" => 403,
                "message" => "Folder $outer is prohibited!",
                "content" => []
            ];

            // Getting file
            $path_agent = new PathConstructor("@resources/$outer/$inner/$file");
            $path = $path_agent->GetReal();
            $file = new File($path);

            // Writing to file
            $file->Write($content);

            // Returning it's content
            return [
                "status"  => 200,
                "message" => "Successfully fetched file",
                "content" => $content
            ];
        }

        /**
         * @name Add 
         * 
         * Adding inner folder
         */
        public function Add(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];
            $data = $request->GetContent();

            $where = $data->where;
            $name = $data->name;

            // Check if folder is not legal
            if(!in_array($where, AppFiles::LegalFolders())) return [
                "status" => 403,
                "message" => "Folder $where is prohibited!",
                "content" => []
            ];

            // Making folder
            $path_agent = new PathConstructor("@resources/$where/$name");
            $path = $path_agent->GetReal();
            $file = new File($path);
            $file->CreateFolder();

            // Cloning
            $clonable_agent = new PathConstructor("@resources/$where/~clone");
            $clonable_path = $clonable_agent->GetReal();
            $clonable_file = new File($clonable_path);

            foreach($clonable_file->FilesProceed() as $file_proceed) {
                // Creating filename (Replace all "Name" with actual name)
                $filename = str_replace("Name", $name, $file_proceed->GetFilename()) . '.' . $file_proceed->GetExtension();

                // Cloning file
                $file_proceed->Clone($path . "/" . $filename);
            }

            // Success
            return [
                "status"  => 200,
                "message" => "Successfully created",
                "content" => $name
            ];
        }

        /**
         * @name LegalFolders
         * @non-controllable
         * 
         * Returns folders (outer folders) that are allowed to be edited
         */
        public static function LegalFolders(): array {
            return [
                "layouts",
                "components",
                "styles"
            ];
        }
    }