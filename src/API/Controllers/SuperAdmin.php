<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;

    class SuperAdmin {
        public array $url_map = [ 'setup' => 'Setup' ];

        /**
         * Creates super admin account whilst setting up application
         * 
         * TODO: CHECK IF APPLICATION IS SETTED UP BEFORE IF IT IS THEN EXIT
         */
        public function Setup(Request $request, App $app): array {
            $data = $request->GetContent();

            $password_hashed = hash('sha256', $data->password);

            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');
            
            $table->Insert([
                'NULL',
                $data->username,
                $data->email,
                $password_hashed,
                'Super Admin',
                date('Y.m.d')
            ]);

            return [
                "status" => 200,
                "message" => "Super admin account was successfully created!"
            ];
        }
    }