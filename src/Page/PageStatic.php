<?php
    namespace Sapphire\Page;

    use Sapphire\Page\Page;
    use Sapphire\Request\Request;
    use Sapphire\Exceptions\HomePageNotFoundException;

    trait PageStatic {
        /**
         * @name GetNewPageIndex
         * 
         * Returns new page index :=> (New Page #(index))
         */
        public static function GetNewPageIndex() {
            global $app;

            return count($app->GetDatabaseHandler()->GetTable('sapphire_pages')->Like([
                ["name", "New page%"]
            ])) + 1;
        }


        /**
         * @name Create
         * 
         * Returns new page (created by ui)
         */
        public static function Create(int $parentId): Page {
            return new Page($parentId);
        }

        /**
         * @name Current
         * 
         * Returns currently viewed page by url
         */
        public static function Current(): Page | null {
            $request = new Request;
            $uri_parts = $request->GetUriPartsFixed();

            $page;
            $previous_id = -1;
            foreach($uri_parts as $uri_part) {
                $page = Page::GetByUrlAndParentId($uri_part, $previous_id);
                if(!$page) continue;

                $previous_id = $page->GetId();
            }

            return $page ?? static::Home();
        }

        /**
         * @name Home
         * 
         * Returns home page
         */
        public static function Home(): Page {
            global $app;
            
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_pages');

            $page = $table->Where([
                ['is_home', '=', true]
            ]);

            if(!$page) throw new HomePageNotFoundException("Sapphire cannot find home page.");

            return Page::From($page);
        }
    }