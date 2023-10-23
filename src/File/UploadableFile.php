<?php
    namespace Sapphire\File;

    use Sapphire\File\File;

    class UploadableFile extends File {
        /**
         * @name AnyExtension
         * 
         * Used in match() function
         */
        public static function AnyExtension(array $values, $value) {
            return in_array($value, $values, true) ? $value : null;
        }


        /**
         * @name GetValidExtensions
         * 
         * Returns all extensions that could be uploaded 
         */
        public static function GetValidExtensions(): array {
            return [
                'jpg',
                'jpeg',
                'bmp',
                'png',
                'gif',
                'webp',
                'svg',
                'mp3',
                'mp4',
                'ogg',
                'css',
                'json',
                'md',
                'txt'
            ];
        }   

        /**
         * @name ValidExtension
         * 
         * Returns if $extension is valid for upload
         */
        public static function ValidExtension(string $extension = null): bool {
            if(!$extension) return false;

            $valid = static::GetValidExtensions();

            return match($extension) {
                static::AnyExtension($valid, $extension) => true,
                default => false
            };
        }

        /**
         * @name HasValidExtension
         * 
         * Returns if \File extension is valid uploadable extension (asset extension like: .png, .jpg etc)
         */
        public function HasValidExtension(): bool {
            return statiic::ValidExtension($this->GetExtension());
        }
    }