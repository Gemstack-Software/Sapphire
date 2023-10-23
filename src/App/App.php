<?php
    namespace Sapphire\App;

    use Sapphire\App\AppSetup;
    use Sapphire\App\AppLock;
    use Sapphire\App\AppView;
    use Sapphire\App\AppUser;
    use Sapphire\App\AppDatabase;
    use Sapphire\App\AppRouter;
    use Sapphire\App\AppPlugins;
    use Sapphire\Setup\SetupInterface;
    use Sapphire\Database\Database;
    use Sapphire\User\User;
    use Sapphire\View\View;
    use Sapphire\View\Viewable;
    use Sapphire\API\API;
    use Sapphire\Router\Router;
    use Sapphire\Router\RouterResource;
    use Sapphire\Component\ComponentIncluder;

    class App 
        implements SetupInterface, Viewable {
        use AppSetup;
        use AppLock;
        use AppView;
        use AppUser;
        use AppDatabase;
        use AppRouter;
        use AppPlugins;
        use ComponentIncluder;

        private Database $database;
        private User $user;
        private API $api;
        private Router $router;
        private RouterResource $resource;

        public function __construct() {
            $this->Setup();
        }

        // TODO: Get it from database
        public function GetLocale(): string {
            return "en";
        }
    }