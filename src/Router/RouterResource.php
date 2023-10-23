<?php
    namespace Sapphire\Router;

    use Sapphire\App\App;

    // Should be enum but php 8 does not have it
    class RouterResource {
        public static string $Page = "Page";
        public static string $Image = "Image";
        public static string $Video = "Video";
        public static string $Sound = "Sound";
        public static string $Stylesheet = "Stylesheet";
        public static string $Script = "Script";
        public static string $JSON = "JSON";
        public static string $StaticFolder = "StaticFolder";

        /**
         * Type of current resource
         */
        protected string $type;

        /**
         * URL Path
         */
        protected string $path;

        /**
         * Resource location
         */
        protected string $location;

        // Getters & Setters
        public function GetType(): string {
            return $this->type;
        } 
        
        public function SetType(string $type): void {
            $this->type = $type;
        }

        public function GetPath(): string {
            return $this->path;
        } 
        
        public function SetPath(string $path): void {
            $this->path = $path;
        }

        public function GetLocation(): string {
            return $this->location;
        } 
        
        public function SetLocation(string $location): void {
            $this->location = $location;
        }

        public function Echo(App $app): void {}
    }