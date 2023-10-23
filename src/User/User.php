<?php
    namespace Sapphire\User;

    use Sapphire\Setup\SetupInterface;
    use Sapphire\User\UserSetup;
    use Sapphire\User\UserAuth;
    use Sapphire\User\UserGetters;
    use Sapphire\User\UserAccessors;
    use Sapphire\User\UserIsNew;
    use Sapphire\User\UserRoles;

    /**
     * Roles:
     * + Guest (unlogged)
     * + Moderator (low level administration (pages content, collection contents, assets))
     * + Admin (higher level administration (ads, analytics, sales management, app files))
     * + Super admin (managing all users, plugins etc)
     */
    class User 
        implements SetupInterface {
        use UserSetup;
        use UserAuth;
        use UserGetters;
        use UserAccessors;
        use UserIsNew;
        use UserRoles;
            
        private int $id;

        private string $username;
        private string $email;
        private string $role;
        private string $created_at;
        private bool $exists = true;
        private bool $is_new = false;

        public function __construct(int $id) {
            $this->id = $id;
            $this->Setup();
        }
    }