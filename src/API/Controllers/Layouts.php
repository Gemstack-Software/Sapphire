<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\File\UploadableFile;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Layout\Layout;
    use Sapphire\Auth\Authenticator;

    class Layouts {
        public array $url_map = [ 
            'all' => 'All'
        ];

        /**
         * @name All
         * 
         * Returns all layouts
         */
        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   

            return [
                "status"  => 200,
                "message" => "Successfully fetched assets",
                "content" => Layout::Layouts()
            ];
        }
    }