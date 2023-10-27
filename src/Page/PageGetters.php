<?php
    namespace Sapphire\Page;

    trait PageGetters {
        /**
         * @name AllArray
         * 
         * Returns all pages as array
         */
        public static function AllArray(): array {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');            

            return $table->AllWhere([
                ["id", ">", 0]
            ]);    
        }

        /**
         * @name ById
         * 
         * Returns page which id: $id
         */
        public static function ById(int $id): Page | null {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');      
            
            return Page::From($table->Where([
                ["id", "=", $id]
            ]));    
        }

        /**
         * @name From
         * 
         * Returns Page class instance from given \stdClass json
         */
        public static function From(\stdClass|null|bool $page_class): Page|null {
            if(!$page_class) return null;

            $page = new Page;
            $page->Set($page_class);

            return $page;
        }

        /**
         * @name GetByUrlAndParentId
         * 
         * Returns Page that url matches passed url and parent_id matches passed id
         */
        public static function GetByUrlAndParentId(string $url, int $parent_id): Page | null {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');      
            
            return Page::From($table->Where([
                ["parent_id", "=", $parent_id],
                ["url", "=", $url]
            ]));    
        }

        /**
         * @name GetChildren
         * 
         * Returns Page children
         */
        public static function GetChildren(int $parent_id): Page | null {
            global $app;

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');      
            
            $pages = [];
            foreach($table->AllWhere([ ["parent_id", "=", $parent_id] ]) as $page)
                $pages[] = Page::From($page);

            return $pages;    
        }
    }
