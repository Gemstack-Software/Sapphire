<?php
    namespace Sapphire\Page;

    trait PageConstruct {
        /**
         * Creates default page for $parentId
         */
        public function __construct(null|int $parentId = null) {
            if(!$parentId) return;  // Constructor without $parentId just returns class Instance empty

            global $app;

            $user = $app->GetUser();    
            $page_index = Page::GetNewPageIndex();
            $current_date = date('Y-m-d H:i:s');

            $this->id = NULL;
            $this->parent_id = $parentId;
            $this->name = "New page" . ($page_index === 1 ? '' : " ($page_index)");
            $this->subname = "This is subname";
            $this->content = "Hello world!";
            $this->url = uniqid();
            $this->layout = "Default";
            $this->is_home = false;
            $this->created_at = $current_date;
            $this->updated_at = $current_date;
            $this->created_by = $user->GetId();
            $this->updated_by = $user->GetId();

            $this->CreateToDatabase();
        }
        
        /**
         * Saves page to database via INSERT INTO (table)
         */
        public function CreateToDatabase(): void {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');    

            $table->Insert($this->ToArrayWithoutKeys());
        }
    }