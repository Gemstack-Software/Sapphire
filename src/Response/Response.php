<?php
    namespace Sapphire\Response;
    
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class Response {
        /**
         * @name Content
         * @static
         * 
         * Changes Content-Type of response
         */
        public static function Content(string $content_type): void {
            header("Content-Type: $content_type");
        }

        /**
         * @name Redirect
         * @static
         * 
         * Redirects response to other url
         */
        public static function Redirect(string $url): void {
            header("Location: $url");
        }

        /**
         * @name Image
         * @static
         * 
         * Returns image as response
         */
        public static function Image(string $image_path): null | array {
            $image_path_agent = new PathConstructor("@/public/$image_path");
            $image = new File($image_path_agent->GetReal());

            if($image->Type() !== File::$Image) {
                Response::Content('application/json');
                return [ "status" => 500, "message" => "Internal Sapphire Error > File $image_path is not an image" ];
            }
             
            $image->Out();
            exit();
        } 
    }   