<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Json\Json;
    use Sapphire\Auth\Authenticator;
    use Sapphire\Plugin\PluginLoader;

    class Plugins {
        public array $url_map = [ 
            'all' => 'All',
        ];

        /**
         * @name All
         * 
         * Returns all plugins
         */
        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];

            $plugins = PluginLoader::All();

            //////////////////////////////////////
            // Obtain configs
            //////////////////////////////////////
            foreach($plugins as $key => $plugin) {
                $plugins[$key] = [
                    "name" => $plugin->GetName(),
                    "config" => $plugin->GetConfig()
                ];
            }

            return [
                "status"  => 200,
                "message" => "Successfully fetched files",
                "content" => $plugins
            ];
        }
    }