<?php
    namespace Sapphire\File;

    use Sapphire\File\FileTypes;
    use Sapphire\File\FileStatic;
    use Sapphire\Exceptions\FileNotFoundException;

    class File {
        use FileTypes;
        use FileStatic;

        private string $path;

        public static function IsTravellerFolder(string $file_name): bool {
            return $file_name === "." || $file_name === "..";
        }

        public function __construct(string $path) {
            $this->path = $path;
        }

        public function Exists(): bool {
            return file_exists($this->path);
        }

        public function Read(): string | null {
            if(!$this->Exists()) return null;

            return file_get_contents($this->path);
        }

        public function Write(string $buffer) {
            file_put_contents($this->path, $buffer);
        }

        public function Json(\stdClass|array|null $buffer = null): \stdClass | null {
            if($buffer) 
                $this->Write(json_encode($buffer));
            else 
                return !$this->Exists() ? null : json_decode($this->Read());

            return null;
        }

        public function GetExtension(): string {
            return static::Extension($this->path);
        }

        public function GetMimeType(): string {
            $extension = $this->GetExtension();
            
            $mime = match ($extension) {
                'png' => 'image/png',
                'jpg', 'jpeg' => 'image/jpeg',
                'svg' => 'image/svg+xml',
                'gif' => 'image/gif',
                default => 'text/plain'
            };

            return $mime;
        }

        /**
         * Includes file (e.g. .php files)
         */
        public function Include(array $data = []) {
            foreach($data as $key => $item) {
                eval("$$key = \$item;");
            }
            
            // if(!$this->Exists()) 
            //     throw new FileNotFoundException("File $this->path cannot be included because it does not exists");

            $buffer = include $this->path;
            return $buffer;
        }

        /**
         * Outputs the content of file to stdout
         */
        public function Out(): void {
            $content = $this->Read();
            $type = $this->GetMimeType();

            header("Content-Type: $type");
            echo $content;
        }

        /**
         * Returns the type of file (Image Video Sound Text etc) to easier check what type of file it is
         */

        public function Type(): string {
            $extension = $this->GetExtension();

            switch($extension) {
                case 'png': 
                case 'jpg':
                case 'jpeg': 
                case 'svg': 
                case 'gif': {
                    return File::$Image;
                } break;
                case 'mp3': {
                    return File::$Audio;
                } break;
                case 'mp4':
                case 'ts': {
                    return File::$Video;
                } break;
                case 'js': {
                    return File::$Script;
                } break;
                case 'css': {
                    return File::$Style;
                } break;
                case 'txt': {
                    return File::$Text;
                } break;
            }

            return File::$Other;
        }

        /**
         * Returns all files in folder  as string-path-files
         */
        public function Files(): array {
            $files = [];

            foreach(scandir($this->path) as $file) {
                if($file === "." || $file === "..") continue;
                
                $files[] = $file;
            }

            return $files;
        }

        /** 
         * Returns all files that have not "~" prefix in filename as string-path-files
         */
        public function NotSecretFiles(): array {
            $files = [];

            foreach($this->Files() as $file) {
                if($file === "." || $file === "..") continue;
                if($file[0] === "~") continue;

                $files[] = $file;
            }

            return $files;
        }

        /**
         * Returns all files that have "~" prefix in filename  as string-path-files
         */
        public function SecretFiles(): array {
            $files = [];

            foreach($this->Files() as $file) {
                if($file === "." || $file === "..") continue;
                if($file[0] !== "~") continue;

                $files[] = $file;
            }

            return $files;
        }

        /**
         * Returns all files in folder  as File class Instance
         */
        public function FilesProceed(): array {
            $files = [];

            foreach(scandir($this->path) as $file) {
                if($file === "." || $file === "..") continue;
                
                $files[] = new File($this->GetPath() . '/' . $file);
            }

            return $files;
        }

        /** 
         * Returns all files that have not "~" prefix in filename as File class Instance
         */
        public function NotSecretFilesProceed(): array {
            $files = [];

            foreach($this->Files() as $file) {
                if($file === "." || $file === "..") continue;
                if($file[0] === "~") continue;

                $files[] = new File($this->GetPath() . '/' . $file);
            }

            return $files;
        }

        /**
         * Returns all files that have "~" prefix in filename  as File class Instance
         */
        public function SecretFilesProceed(): array {
            $files = [];

            foreach($this->Files() as $file) {
                if($file === "." || $file === "..") continue;
                if($file[0] !== "~") continue;

                $files[] = new File($this->GetPath() . '/' . $file);
            }

            return $files;
        }

        /**
         * Moves the file (only these which were not uploaded)
         */
        public function Move(string $new_path): void {
            static::RenameFile($this->path, $new_path);
        }

        /**
         * Moves the uploaded file
         */
        public function MoveUploaded(string $new_path): void {
            static::MoveUploaded($this->path, $new_path);
        }

        /**
         * Deletes file
         */
        public function Delete(): void {
            static::DeleteFile($this->path);
        }

        /**
         * Returns path
         */
        public function GetPath(): string {
            return $this->path;
        }

        /**
         * Returns filename
         */
        public function GetFilename(): string {
            return static::Filename($this->path);
        }

        /**
         * Returns if file is onyx file
         */
        public function IsOnyx(): bool {
            return $this->GetExtension() === "onyx";
        }

        /**
         * Clone file to $location
         */
        public function Clone(string $location): void {
            static::CloneFile($this->path, $location);
        }

        /**
         * Creates folder (Mkdir)
         */
        public function CreateFolder(): void {
            static::CreateNewFolder($this->path);
        }

        /**
         * Gets the file child
         */
        public function GetChild(string $filename): File {
            return new File($this->path . '/' . $filename);
        }
    }