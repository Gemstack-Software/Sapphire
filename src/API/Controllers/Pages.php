<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;
    use Sapphire\Page\Page;
    use Sapphire\Auth\Authenticator;

    class Pages {
        public array $url_map = [ 
            'all' => 'All',
            'create' => 'Create',
            'full-url' => 'FullUrl',
            'save' => 'Save',
            'delete' => 'Delete',
            'id' => 'GetById',
            'properties' => 'GetProperties',
            'create-property' => 'CreateProperty',
            'delete-property' => 'DeleteProperty',
            'save-property' => 'SaveProperty'
        ];

        /**
         * Returns all pages that are avaliable in this webapp
         */
        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   

            return [
                "status" => 200,
                "message" => "Successfully returning all pages",
                "content" => Page::AllArray()
            ];
        }

        /**
         * Creates a new page for this webapp
         */
        public function Create(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   

            $data = $request->GetContent();
            $page = Page::Create($data->parentId);

            return [
                "status" => 200,
                "message" => "Successfully created new page",
                "content" => $page
            ];
        }
        
        /**
         * Returns full url of page by it's id
         */
        public function FullUrl(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   

            $page_id = $request->GetParamByIndex(0);
            $page = Page::ById($page_id);

            if(!$page) 
                return [ "status" => 404, "message" => "Page does not exists!" ];

            return [
                "status" => 200,
                "message" => "Successfully got page full url",
                "content" => $page->GetFullUrl()
            ];
        }

        /**
         * Updates page with params given in request
         */
        public function Save(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   

            $data = $request->GetContent();

            if($data->page->is_home) 
                Page::ClearHomePage();

            $page = Page::ById($data->page->id);
            $page->Set($data->page);
            $page->Save();

            return [
                "status"    => 200,
                "message"   => "Successfully updated page",
                "content"   => $page->ToArray()
            ];
        }

        /**
         * Delete page with given id
         */
        public function Delete(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];                   

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');
            $data = $request->GetContent();
            $id = $data->id;

            $table->DeleteSingle(whereId: $id);

            return [
                "status"    => 200,
                "message"   => "Page successfully deleted",
                "content"   => null
            ];
        }
    
        /**
         * Gives page by id given in url params
         */
        public function GetById(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            $id = $request->GetParamByIndex(0);

            $page = Page::ById($id);
            $page_exists = !! $page;

            return [
                "status"    => $page_exists ? 200 : 404,
                "message"   => $page_exists ? "Successfully gave page" : "Error 404 - page with id $id does not exists in system",
                "content"   => $page_exists ? $page->Serialize() : null
            ];
        }

        /**
         * Returns page properties
         */
        public function GetProperties(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            $id = $request->GetParamByIndex(0);

            $page = Page::ById($id);
            $page_exists = !! $page;

            return [
                "status"    => $page_exists ? 200 : 404,
                "message"   => $page_exists ? "Successfully gave properties" : "Error 404 - page with id $id does not exists in system",
                "content"   => $page_exists ? $page->Properties() : null
            ];
        }

        /**
         * Creates new page property
         * 
         * TODO: Page::CreateProperty method
         */
        public function CreateProperty(Request $request, App $app): array {
            global $app;

            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            
            ////////////////////////////////
            // Get database and table
            ////////////////////////////////
            $data = $request->GetContent();
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages_properties');

            ////////////////////////////////
            // Create Property
            ////////////////////////////////
            $table->Insert([
                NULL,
                $data->id,
                $data->name,
                ''
            ]);

            return [
                'status' => 200,
                'message' => 'Successfully created property',
                'content' => []
            ];
        }

        /**
         * Deletes property
         * 
         * TODO: Page::DeleteProperty method
         */
        public function DeleteProperty(Request $request, App $app): array {
            global $app;

            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
            $id = $request->GetParamByIndex(0);

            ////////////////////////////////
            // Get database and table
            ////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages_properties');

            $table->DeleteSingle(
                whereId: $id
            );

            return [
                'status' => 200,
                'message' => 'Successfully deleted property',
                'content' => []
            ];
        }

        /**
         * Saves property
         * 
         * TODO: Page::SaveProperty() method
         */
        public function SaveProperty(Request $request, App $app): array {
            global $app;

            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];
        

            ////////////////////////////////
            // Get database and table
            ////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages_properties');
            $data = $request->GetContent();

            $table->UpdateSingle(
                updates: [ 'value' => $data->value ],
                whereId: $data->id
            );

            return [
                'status' => 200,
                'message' => 'Successfully saved property',
                'content' => []
            ];
        }
    }