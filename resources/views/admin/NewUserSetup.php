<?php $app->View('components/Top', ['app' => $app]); ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true]); ?>
    <body>
        <div id="cms-app__root">
            <NewUserSetup userString="<?php $app->GetUser()->Out(); ?>"></NewUserSetup>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]); ?>