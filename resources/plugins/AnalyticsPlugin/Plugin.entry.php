<?php
    use Sapphire\Plugin\Plugin;
    use Sapphire\Plugin\Helpers\Sidebar;
    use Sapphire\Plugin\Helpers\Router;
    use Sapphire\Plugin\Helpers\AssetInjector;
    use Sapphire\Analytics\Handlers\HandleDatabase;
    use Sapphire\Analytics\Handlers\Analytics;
    use Sapphire\Analytics\Events\Enable as EnableEvent;
    use Sapphire\Database\DatabaseTable;

    class AnalyticsPlugin extends Plugin {
        use EnableEvent;
        use Sidebar;
        use Router;
        use AssetInjector;
        use Analytics;
        use HandleDatabase;

        protected DatabaseTable $table;

        public function Init(): void {
            /////////////////////////////////////////
            // Register required events
            /////////////////////////////////////////
            $this->RegisterEvents([
                'onEnable' => [$this, 'HandleEnable'],
                'onAdminHead' => [$this, 'HandleGenerateStart']
            ]);

            /////////////////////////////////////////
            // Add route
            /////////////////////////////////////////
            $this->AddRoute(path: '/admin/analytics', view: 'Analytics', data: [ 'plugin' => $this ]);

            /////////////////////////////////////////
            // Init database
            /////////////////////////////////////////
            $this->InitAnalyticsDatabase();

            /////////////////////////////////////////
            // Init analytics
            /////////////////////////////////////////
            $this->InitAnalytics();
        } 

        public function HandleGenerateStart(): void {
            $this->InjectScript(__DIR__ . '/dist/index.js');
            $this->InjectStyle(__DIR__ . '/dist/index.css');

            /////////////////////////////////////////
            // Create sidebar button
            /////////////////////////////////////////
            $this->CreateSidebarButton(
                name: "Analytics",
                icon: "fas fa-chart-simple",
                link: "/admin/analytics"
            );
        }
    }

    return AnalyticsPlugin::class;