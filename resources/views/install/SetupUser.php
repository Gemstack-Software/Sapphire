<?php $app->View('components/Top', ['app' => $app]); ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true]); ?>
    <body>
        <div id="cms-app__root">
            <SetupUser></SetupUser>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]); ?>