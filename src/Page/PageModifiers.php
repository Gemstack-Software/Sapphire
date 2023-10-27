<?php
    namespace Sapphire\Page;

    use Sapphire\Layout\Layout;

    define("SAPPHIRE_PAGE_TABLE_COLUMN_INDEXES", [
        "id",
        "parent_id",
        "name",
        "subname",
        "content",
        "url",
        "layout",
        "is_home",
        "created_at",
        "created_by",
        "updated_at",
        "updated_by"
    ]);

    trait PageModifiers {
        /**
         * Set privates properties from \stdClass object
         */
        public function Set(\stdClass $data) {
            foreach($data as $key => $value) {
                $column = SAPPHIRE_PAGE_TABLE_COLUMN_INDEXES[$key] ?? $key;

                $this->{$column} = $value;
            }
        }

        /**
         * ==================================
         *  Page properties getters
         * ==================================
         * 
         */
        public function GetParentId(): int {
            return $this->parent_id;
        }
        
        public function GetId(): int {
            return $this->id;
        }

        public function GetName(): string {
            return $this->name;
        }

        public function GetSubname(): string {
            return $this->subname;
        }

        public function GetContent(): string {
            return $this->content;
        }

        public function GetUrl(): string {
            return $this->url;
        }

        public function IsHome(): bool {
            return !!$this->is_home;
        }

        /**
         * @name GetLayout
         * 
         * Returns layout of our page
         */
        public function GetLayout(): Layout | null {
            return Layout::Init($this->layout);
        }

        /**
         * @name Children
         * 
         * Returns all children pages
         */
        public function Children(): array {
            return static::GetChildren($this->GetId());
        }
    }
