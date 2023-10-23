<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Auth\Authenticator;

    class Disk {
        public array $url_map = [ 'data' => 'Data' ];

        public function Data(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderator" ];
            if(Authenticator::Admin()) return [ "status" => 403, "message" => "Forbidden for admin" ];

            /////////////////////////////////////////
            // Get the disk size
            /////////////////////////////////////////
            $path_agent = new PathConstructor("@");
            $disk_usage = File::GetFolderSize($path_agent->GetReal());

            /////////////////////////////////////////
            // Get specified sizes
            /////////////////////////////////////////
            $collections_size = File::GetFolderSize((new PathConstructor("@resources/collections"))->GetReal()) + File::GetFolderSize((new PathConstructor("@resources/~trash"))->GetReal());
            $components_size = File::GetFolderSize((new PathConstructor("@resources/components"))->GetReal());
            $layouts_size = File::GetFolderSize((new PathConstructor("@resources/layouts"))->GetReal());
            $plugins_size = File::GetFolderSize((new PathConstructor("@resources/plugins"))->GetReal());
            $styles_size = File::GetFolderSize((new PathConstructor("@resources/styles"))->GetReal());
            $node_modules_size = File::GetFolderSize((new PathConstructor("@node_modules"))->GetReal());
            $trash_size = File::GetFolderSize((new PathConstructor("@resources/~trash"))->GetReal());

            return [ 
                "status" => 200,
                "message" => "Successfully returned size of app",
                "content" => [
                    "size" => $disk_usage,
                    "components" => $components_size,
                    "collections" => $collections_size,
                    "layouts" => $layouts_size,
                    "plugins" => $plugins_size,
                    "styles" => $styles_size,
                    "node_modules" => $node_modules_size,
                    "trash" => $trash_size
                ]
            ];
        }
    }