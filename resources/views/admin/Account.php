<?php $app->View('components/Top', ['app' => $app]) ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true]) ?>
    <body>
        <div id="cms-app__root">
            <div class="app-container">
                <Sidebar userString="<?php $app->GetUser()->Out(); ?>" active="account"></Sidebar>

                <div class="app-content-container content-builder">
                    <Account userString="<?php $app->GetUser()->Out(); ?>"></Account>

                    <?php $app->View('components/Footer') ?>
                </div>
            </div>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]) ?>