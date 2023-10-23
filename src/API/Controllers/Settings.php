<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Settings\SettingsManager;
    use Sapphire\Auth\Authenticator;

    class Settings {
        public array $url_map = [ 
            'all' => 'All',
            'save' => 'Save'
        ];

        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];                   
            if(Authenticator::Admin()) return [ "status" => 403, "message" => "Forbidden for admins" ];                   

            $settings = SettingsManager::GetAll();

            /////////////////////////////////////////
            // Settings not exists
            /////////////////////////////////////////
            if(!$settings) return [ 
                "status" => 404, 
                "message" => "Fetching settings failed. Settings file (file: App.json at: @resources/configs) not found." 
            ];
            
            /////////////////////////////////////////
            // Return settings
            /////////////////////////////////////////
            return [ 
                "status" => 200,
                "message" => "Successfully returned settings",
                "content" => $settings
            ];
        }

        /**
         * Save settings to settings file
         */
        public function Save(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];                   
            if(Authenticator::Admin()) return [ "status" => 403, "message" => "Forbidden for admins" ];    
            
            $settings = $request->GetContent()->settings;

            if(SettingsManager::Save($settings)) {
                return [
                    "status" => 200,
                    "message" => "Successfully saved settings",
                    "content" => $settings
                ];
            }

            return [
                "status" => 500,
                "message" => "Unknown error whilst saving settings",
                "content" => []
            ];
        }
    }