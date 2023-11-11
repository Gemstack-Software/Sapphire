<?php
    namespace Sapphire\API;
    
    use Sapphire\Api\Controllers\SuperAdmin;
    use Sapphire\Api\Controllers\Auth;
    use Sapphire\Api\Controllers\User;
    use Sapphire\Api\Controllers\Collections;
    use Sapphire\Api\Controllers\Assets;
    use Sapphire\Api\Controllers\Pages;
    use Sapphire\Api\Controllers\Layouts;
    use Sapphire\Api\Controllers\AppFiles;
    use Sapphire\Api\Controllers\Disk;
    use Sapphire\Api\Controllers\Settings;
    use Sapphire\Api\Controllers\Plugins;

    /**
     * Returns all sapphire controllers
     */
    return [
        'super-admin' => SuperAdmin::class,
        'auth' => Auth::class,
        'user' => User::class,
        'collections' => Collections::class,
        'assets' => Assets::class,
        'pages' => Pages::class,
        'layouts' => Layouts::class,
        'app-files' => AppFiles::class,
        'disk' => Disk::class,
        'settings' => Settings::class,
        'plugins' => Plugins::class
    ];