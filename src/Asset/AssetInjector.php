<?php
    namespace Sapphire\Asset;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class AssetInjector {
        /**
         * Inject file into /public/assets/injected and returns it's path
         */
        public static function Inject(string $path): string {
            /////////////////////////////////////////
            // Construct paths
            /////////////////////////////////////////
            $asset_path_agent = new PathConstructor($path);
            $asset_path = $asset_path_agent->GetReal();

            $clone_path_agent = new PathConstructor("@public/assets/injected");
            $clone_path = $clone_path_agent->GetReal();

            /////////////////////////////////////////
            // Init file
            /////////////////////////////////////////
            $file = new File($asset_path);
            $extension = $file->GetExtension();
            
            /////////////////////////////////////////
            // Clone hash
            /////////////////////////////////////////
            $clone_hash = hash('sha256', $asset_path);

            /////////////////////////////////////////
            // Create dist file path and clone file
            /////////////////////////////////////////
            $dist_file_path = $clone_hash . '.' . $extension;
            $dist_file_full_path = $clone_path . '/' . $dist_file_path;

            $file->Clone($dist_file_full_path);

            return $dist_file_path;
        }

        /**
         * Inject script file and echo it
         */
        public static function InjectScript(string $path): void {
            $dist_file_path = static::Inject($path);
        
            /////////////////////////////////////////
            // Echo script
            /////////////////////////////////////////
            echo '<script src="/assets/injected/' . $dist_file_path . '"></script>';
        }
  
        /**
         * Inject style file and echo it
         */
        public static function InjectStyle(string $path): void {
            $dist_file_path = static::Inject($path);
        
            /////////////////////////////////////////
            // Echo style link
            /////////////////////////////////////////
            echo '<link rel="stylesheet" href="/assets/injected/' . $dist_file_path . '">';
        }
    }