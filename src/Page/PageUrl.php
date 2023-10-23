<?php
    namespace Sapphire\Page;

    use Sapphire\Page\Page;

    trait PageUrl {
        /**
         * @string $previous is used in recursion
         * 
         * Returns full url of page using parent pages
         */
        public function GetFullUrl(string $previous = ''): string {
            $has_parent = $this->parent_id !== -1;

            if($has_parent) {
                $parent = Page::ById($this->parent_id);
                if(!$parent) return $previous;

                return $parent->GetFullUrl($this->url . ($previous !== "" ? "/$previous" : ""));
            }

            return "" . $this->url . ($previous !== "" ? "/$previous" : "");
        }
    }