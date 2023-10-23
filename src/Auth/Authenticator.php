<?php
    namespace Sapphire\Auth;

    /**
     * Provides methods for easier authentication
     */
    class Authenticator {
        /**
         * Checks if user is authenticated (logged into system)
         */
        public static function Authenticated(): bool {
            global $app;

            return ! ($app->GetUser()->IsGuest());
        } 

        /**
         * Checks user role
         */
        public static function PermissionRole(): string {
            global $app;

            return $app->GetUser()->GetRole();
        }

        /**
         * Checks if user is guest
         */
        public static function Guest(): bool {
            return ! static::Authenticated();
        }

        /**
         * Checks if user is moderator
         */
        public static function Moderator(): bool {
            return static::PermissionRole() == "Moderator";
        }

        /**
         * Checks if user is admin
         */
        public static function Admin(): bool {
            return static::PermissionRole() == "Admin";
        }

        /**
         * Checks if user is super admin
         */
        public static function SuperAdmin(): bool {
            return static::PermissionRole() == "Super Admin";
        }
    }