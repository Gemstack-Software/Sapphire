<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;

    class Auth {
        public array $url_map = [ 'login-credentials' => 'UsernameOrEmailLoginData', 'sign-in' => 'SignIn', 'sign-out' => 'SignOut' ];

        /**
         * Provides username and avatar whilst siging-in for showing after passing username or email
         */
        public function UsernameOrEmailLoginData(Request $request, App $app): array {
            $data = $request->GetContent();

            // Get user by credentials
            $credential = $data->credential;
            $user = User::ByCredential($credential);

            // Creating content to response
            $user_content = $user ? [
                'username' => $user->GetUsername(),
                'avatar' => $user->GetAvatar()
            ] : null;

            return [
                "status" => $user ? 200 : 404,
                "message" => $user ? "User found!" : "User with this credentials not found!",
                "content" => $user_content
            ];
        }

        /**
         * Login into application
         */
        public function SignIn(Request $request, App $app): array {
            $data = $request->GetContent();

            // Getting credentials
            $username = $data->username;
            $password = $data->password;
        
            // Getting the user
            $user = User::ByLogin($username, $password);

            // Saving user data
            if($user) {
                $_SESSION["sapphire_user_logged"] = true;
                $_SESSION["sapphire_user_id"] = $user->GetId();
            }

            return [
                "status" => $user ? 200 : 404,
                "message" => $user ? "Successfully logged in" : "Failed to login!",
                "user" => $user ? $user->GetId() : null
            ];
        }

        /**
         * Delete user session (Sign out user from application) and redirect it into login page
         */
        public function SignOut(Request $request, App $app): array {
            session_unset();
            session_destroy();

            return Response::Redirect('/admin');
        }
    }