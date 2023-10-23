<?php 
    namespace Sapphire\Collection;

    use Sapphire\File\File;
    use Sapphire\Collection\CollectionFactory;
    use Sapphire\Collection\CollectionEntryFactory;
    use Sapphire\Collection\CollectionQueries;
    use Sapphire\Collection\CollectionUtilities;
    use Sapphire\Collection\CollectionSaver;
    use Sapphire\Serialize\Serialize;

    class Collection {
        use CollectionFactory;
        use CollectionEntryFactory;
        use CollectionQueries;
        use CollectionSaver;
        use CollectionUtilities;
        use CollectionAPI;
        use Serialize;

        // This properties are public to easier serialization (json)
        public CollectionInfo $info;
        public CollectionSchema $schema;
        public array $contents;

        public function SetInfo(CollectionInfo $info): void {
            $this->info = $info;
        }

        public function SetSchema(CollectionSchema $schema): void {
            $this->schema = $schema;
        }

        public function SetContents(array $contents): void {
            $this->contents = $contents;
        }
    }