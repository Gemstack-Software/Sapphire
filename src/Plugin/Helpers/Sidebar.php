<?php
    namespace Sapphire\Plugin\Helpers;

    trait Sidebar {
        public function CreateSidebarButton(
            string $name,
            string $icon,
            string $link
        ): void {
            echo "<script sidebar-button>window.adminSidebarNavigation.push({ name: `$name`, icon: `$icon`, link: `$link` })</script>";
        }
    }