<?php
    namespace Sapphire\Page;
    use Sapphire\Json\Json;

    trait PageSerialize {
        /**
         * @name ToArray
         * 
         * Returns page as array of key-value pairs
         */
        public function ToArray(): array {
            return [
                'id' => $this->id,
                'parent_id' => $this->parent_id,
                'name' => $this->name,
                'subname' => $this->subname,
                'content' => $this->content,
                'url' => $this->url,
                'layout' => $this->layout,
                'is_home' => $this->is_home,
                'created_at' => $this->created_at,
                'created_by' => $this->created_by,
                'updated_at' => $this->updated_at,
                'updated_by' => $this->updated_by
            ];
        }

        /**
         * @name ToArrayWithoutKeys
         * 
         * Returns page as array of properties
         */
        public function ToArrayWithoutKeys(): array {
            return [
                $this->id,
                $this->parent_id,
                $this->name,
                $this->subname,
                $this->content,
                $this->url,
                $this->layout,
                $this->is_home,
                $this->created_at,
                $this->created_by,
                $this->updated_at,
                $this->updated_by
            ];
        }


        /**
         * @name Serialize
         * 
         * Returns Json maked serialized array of this class
         */
        public function Serialize(): string | array | \stdClass {
            return Json::Make($this->ToArray());
        }
    }