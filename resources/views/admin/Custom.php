<?php $app->View('components/Top', ['app' => $app]) ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true, 'monaco' => true]) ?>
    <body>
        <div id="cms-app__root">
            <div class="app-container">
                <Sidebar userString="<?php $app->GetUser()->Out(); ?>" active="<?php echo $container["name"] ?>"></Sidebar>

                <div class="app-content-container content-builder">
                    <?php $app->View($container["name"], ['app' => $app, 'params' => $container["params"]], $container["root_folder"]) ?>

                    <?php $app->View('components/Footer') ?>
                </div>
            </div>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]) ?>