<?php
    namespace Sapphire\Component\Helpers;

    trait Assets {
        /**
         * @param label {string} - Label name of asset 
         * 
         * Returns path to asset uploaded to Sapphire
         */
        public function Asset(string $label = null, int $id = null): null | string {
            global $app;

            ///////////////////////////////////////////////////////////
            // Getting the database
            ///////////////////////////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_assets');

            ///////////////////////////////////////////////////////////
            // Asset by id
            ///////////////////////////////////////////////////////////
            if(!$label) {
                $asset = $table->Where([
                    ["id", "=", $id]
                ]);

                return !$asset ? null : $asset->filename;
            }

            ///////////////////////////////////////////////////////////
            // Getting the asset
            ///////////////////////////////////////////////////////////
            $asset = $table->Where([
                ["label", "=", $label]
            ]);

            return !$asset ? null : $asset->filename;
        }
    }
