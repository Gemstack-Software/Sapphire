<?php
    namespace Sapphire\File;

    use Sapphire\Path\PathConstructor;

    trait FileStatic {
        /**
         * @name Extension
         * 
         * Returns file $path extension
         */
        public static function Extension(string $path): string {
            return strtolower(pathinfo($path, PATHINFO_EXTENSION));
        }

        /**
         * @name GenerateTemporary
         * 
         * Returns temp file path
         */
        public static function GenerateTemporary(string $extension): string {
            $path_agent = new PathConstructor('@/resources/~temp/' . uniqid('temp-') . '.' . $extension);

            return $path_agent->GetReal();
        }
    
        /**
         * @name MoveUploadedFile
         * 
         * Move uploaded files from: $from to: $to path
         */
        public static function MoveUploadedFile(string $from, string $to): void {
            move_uploaded_file($from, $to);
        }

        /**
         * @name RenameFile
         * 
         * Renames file
         */
        public static function RenameFile(string $from, string $to): void {
            rename($from, $to);
        }

        /**
         * @name MoveFile
         * 
         * Moves file from $from to $to path
         */
        public static function MoveFile(string $from, string $to): void {
            static::RenameFile($from, $to);
        }

        /**
         * @name DeleteFile
         * 
         * Deletes file in path $path
         */
        public static function DeleteFile(string $file): void {
            unlink($file);
        }

        /**
         * @name Filename
         * 
         * Returns filename from path
         */
        public static function Filename(string $path): string {
            return pathinfo($path, PATHINFO_FILENAME);
        }

        /**
         * @name CloneFile
         * 
         * Clones file a to file b
         */
        public static function CloneFile(string $a, string $b): void {
            $base_file = new File($a);
            $cloned_file = new File($b);

            $cloned_file->Write($base_file->Read());
        }

        /**
         * @name CreateNewFolder
         * 
         * Creates new folder
         */
        public static function CreateNewFolder(string $path): void {
            mkdir($path);
        }

        /**
         * @name GetFolderSize
         * 
         * Returns size of folder
         */
        public static function GetFolderSize(string $path): int {
            $dir_size = 0;

            if(is_dir($path)) {
                if($dir_handle = opendir($path)) {
                    while(($file = readdir($dir_handle)) !== false) {
                        if($file !== "." && $file !== "..") {
                            if(is_file($path . "/" . $file)) $dir_size += filesize($path . "/" . $file);
                            if(is_dir($path . "/" . $file)) $dir_size += static::GetFolderSize($path . "/" . $file);
                        }
                    }
                }
            }

            closedir($dir_handle);

            return $dir_size;
        }
    }