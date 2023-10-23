<?php $app->View('components/Top', ['app' => $app]) ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true, 'monaco' => true]) ?>
    <body>
        <div id="cms-app__root">
            <div class="app-container">
                <Sidebar userString="<?php $app->GetUser()->Out(); ?>" active="app"></Sidebar>

                <div class="app-content-container content-builder">
                    <?php if($app->GetUser()->IsAdmin() || $app->GetUser()->IsSuperAdmin()): ?>
                        <AppEditor></AppEditor>

                        <?php $app->View('components/Footer') ?>
                    <?php else: ?>
                        <?php $app->View('components/Forbidden') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]) ?>