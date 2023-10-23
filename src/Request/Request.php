<?php
    namespace Sapphire\Request;

    use Sapphire\File\File;
    use Sapphire\Path\PathConstructor;

    class Request {
        public function GetContent(): \stdClass | null {
            return json_decode(file_get_contents('php://input'));
        }

        public function GetUrlPath(): string {
            return $_SERVER["REQUEST_URI"];
        }

        public function GetUriParts(): array {
            return explode("/", $this->GetUrlPath());
        }

        /**
         * Return array of url path parts without first empty item 
         */
        public function GetUriPartsFixed(): array { 
            $parts = $this->GetUriParts();
            array_shift($parts);

            return $parts;
        }

        /**
         * Returns n part of url path offseted by (null / api / controller / method) - Anonymous Parameters
         */
        public function GetParamByIndex(int $param_id): string | null {
            $uri_parts = $this->GetUriParts();
            $param_id += 4; // Offset of uri_parts (NULL/API/CONTROLLER/METHOD)

            if(count($uri_parts) <= $param_id) return null;

            return $uri_parts[$param_id];
        }

        /**
         * Returns upload file
         */
        public function File(string $filename): File | null {
            $file = $_FILES[$filename];
            if(!$file) return null;

            // Get the extension
            $extension = File::Extension($file["name"]);

            // Generates temp path location
            $temp_path = File::GenerateTemporary($extension);

            // Move uploaded file to temp path
            File::MoveUploadedFile($file["tmp_name"], $temp_path);

            // Returning file
            return new File($temp_path);
        }

        /**
         * Get the client ip address
         */
        public function GetIP(): string {
            return $_SERVER['REMOTE_ADDR'];
        }
    }