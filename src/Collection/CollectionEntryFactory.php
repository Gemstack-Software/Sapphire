<?php
    namespace Sapphire\Collection;

    use Sapphire\File\File;
    use Sapphire\Collection\Collection;
    use Sapphire\Collection\CollectionInfo;
    use Sapphire\Path\PathConstructor;
    use Sapphire\Json\Json;
    use Sapphire\User\User;

    trait CollectionEntryFactory {
        /**
         * @name MakeEntry
         * 
         * Makes collection entry with name: $name from data: $filled_data by user: $user
         */
        public function MakeEntry(string $name, \stdClass $filled_data, User $user): \stdClass {
            $data = [];
            $current_date = date('Y-m-d H:i:s');

            if($this->schema->info->id)           $data["id"] = $this->LastEntryIndex() + 1;
            if($this->schema->info->uuid)         $data["uuid"] = uniqid();
            if($this->schema->info->name)         $data["name"] = $name;
            if($this->schema->info->created_at)   $data["created_at"] = $current_date;
            if($this->schema->info->updated_at)   $data["updated_at"] = $current_date;
            if($this->schema->info->created_by)   $data["created_by"] = $user->GetId();
            if($this->schema->info->updated_by)   $data["updated_by"] = $user->GetId();

            $data["attributes"] = $filled_data;

            // Fabricating entry
            return Json::Make($data);
        }
    }