<?php
    namespace Sapphire\Component\Helpers;

    trait Assets {
        /**
         * @param label {string} - Label name of asset 
         * 
         * Returns path to asset uploaded to Sapphire
         */
        public function Asset(string $label = null): null | string {
            global $app;

            ///////////////////////////////////////////////////////////
            // Check if label is passed
            ///////////////////////////////////////////////////////////
            if(!$label) return null;

            ///////////////////////////////////////////////////////////
            // Getting the database
            ///////////////////////////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            ///////////////////////////////////////////////////////////
            // Getting the asset
            ///////////////////////////////////////////////////////////
            $asset = $table->Where([
                ["label", "=", $label]
            ]);

            if(!$asset) return null;

            return $asset->filename;
        }
    }