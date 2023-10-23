<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User as SapphireUser;
    use Sapphire\Auth\Authenticator;

    class User {
        public array $url_map = [ 
            'avatar' => 'Avatar',
            'username' => 'Username',
            'all' => 'All',
            'create' => 'Create',
            'delete' => 'Delete',
            'change-password' => 'ChangePassword',
            'change-username' => 'ChangeUsername'
        ];

        /**
         * @name Avatar
         * @url /api/user/avatar/<id>
         * 
         * Returns an avatar image of user with id <id>
         * If user is not logged then return 
         */
        public function Avatar(Request $request, App $app): array {
            $user_id = $request->GetParamByIndex(0);
            if(!$user_id) return [ "status" => 400, "message" => "Bad request - invalid user id" ];

            $user = SapphireUser::ById($user_id);
            if(!$user->Exists()) return [ "status" => 404, "message" => "User with this id not found!" ];

            $avatar_path = $user->GetAvatar();

            return Response::Image($avatar_path);
        }

        /**
         * @name Username
         * @url /api/user/username/<id>
         * 
         * Returns username of user with id: $id
         */
        public function Username(Request $request, App $app): array {
            $user_id = $request->GetParamByIndex(0);
            if(!$user_id) return [ "status" => 400, "message" => "Bad request - invalid user id" ];

            $user = SapphireUser::ById($user_id);
            if(!$user) return [ "status" => 404, "message" => "User with id: $user_id not found!" ];
 
            return [ "status" => 200, "message" => "Successfully returned username", "content" => $user->GetUsername() ];
        }

        /**
         * @name All
         * @url /api/user/all
         * 
         * Returns all users
         */
        public function All(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];                   
            if(Authenticator::Admin()) return [ "status" => 403, "message" => "Forbidden for admins" ];    
            
            return [
                "status" => 200,
                "message" => "Successfully returned all users",
                "content" => SapphireUser::All()
            ];
        }

        /**
         * @name Create
         * @url /api/user/create
         * 
         * Creates user
         */
        public function Create(Request $request, App $app): array {
            if(Authenticator::Guest()) return [ "status" => 403, "message" => "Forbidden for guests" ];                   
            if(Authenticator::Moderator()) return [ "status" => 403, "message" => "Forbidden for moderators" ];                   
            if(Authenticator::Admin()) return [ "status" => 403, "message" => "Forbidden for admins" ];    

            $data = $request->GetContent();

            ////////////////////////////////////
            // Get database
            ////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');
            
            ////////////////////////////////////
            // Insert new user
            ////////////////////////////////////
            $table->Insert([
                'NULL',
                'New user ' . uniqid("#"),
                $data->email,
                hash('sha256', ''),
                $data->role,
                date('Y.m.d')
            ]);

            ////////////////////////////////////
            // Response
            ////////////////////////////////////
            return [
                'status' => 200,
                'message' => 'Successfully created user',
                'content' => []
            ];
        }

        /**
         * @name Delete
         * @url /api/user/delete
         * 
         * Deletes user
         */
        public function Delete(Request $request, App $app): array {
            $data = $request->GetContent();

            ///////////////////////////////////////////////
            // Check if user is authorized to do it
            ///////////////////////////////////////////////
            $current = SapphireUser::Session();
            if(!($current->IsSuperAdmin() || $current->id === $data->id)) return [
                'status' => 403,
                'message' => 'Forbidden. User has no access to user account'
            ];

            ////////////////////////////////////
            // Get database
            ////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            ////////////////////////////////////
            // Delete user
            ////////////////////////////////////
            $table->DeleteSingle(whereId: $data->id);

            return [
                'status' => 200,
                'message' => "Successfully deleted user",
                'content' => []
            ];
        }

        /**
         * @name ChangePassword
         * @url /api/user/change-password
         * 
         * Changes password
         * TODO: Check if current user is user to change password or super admin
         */
        public function ChangePassword(Request $request, App $app): array {
            $data = $request->GetContent();

            ///////////////////////////////////////////////
            // Check if user is authorized to do it
            ///////////////////////////////////////////////
            $current = SapphireUser::Session();
            if(!($current->IsSuperAdmin() || $current->id === $data->id)) return [
                'status' => 403,
                'message' => 'Forbidden. User has no access to user account'
            ];

            ////////////////////////////////////
            // Get database
            ////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            ////////////////////////////////////
            // Get data
            ////////////////////////////////////          
            $id = $data->id;
            $password = $data->password;
            $hashed_password = hash('sha256', $password);

            ////////////////////////////////////
            // Update user
            ////////////////////////////////////
            $table->UpdateSingle([
                "password" => $hashed_password
            ], whereId: $id);

            return [
                'status' => 200,
                'message' => 'Successfully changed new user password'
            ];
        }

        /**
         * @name ChangeUsername
         * @url /api/user/change-username
         *
         * Changes username
         */
        public function ChangeUsername(Request $request, App $app): array {
            $data = $request->GetContent();

            ///////////////////////////////////////////////
            // Check if user is authorized to do it
            ///////////////////////////////////////////////
            $current = SapphireUser::Session();
            if(!($current->IsSuperAdmin() || $current->id === $data->id)) return [
                'status' => 403,
                'message' => 'Forbidden. User has no access to user account'
            ];

            ///////////////////////////////////////////////
            // Get database
            ///////////////////////////////////////////////
            $database = $app->GetDatabaseHandler();
            $table = $database->GetTable('sapphire_users');

            ///////////////////////////////////////////////
            // Check if any user has this username
            ///////////////////////////////////////////////
            if(count($table->AllWhere([
                ["username", "=", $data->username]
            ])) !== 0) return [
                'status' => 500,
                'message' => 'User with this username currently exists'
            ];
 
            ///////////////////////////////////////////////
            // Update user
            ///////////////////////////////////////////////
            $table->UpdateSingle([
                "username" => $data->username
            ], whereId: $data->id);

            return [
                'status' => 200,
                'message' => 'Successfully changed username'
            ];
        }
    }