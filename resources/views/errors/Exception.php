<?php
    use Sapphire\File\File;
    use Sapphire\Code\Code;

    // Getting the line where exception is executed
    $line = intval($exception->GetLine());

    // Getting content of file where exception is executed
    $file = new File($exception->GetFile());
    $content = $file->Read();

    // Getting extension of source file
    $extension = $file->GetExtension();

    // Array of code lines from file
    $lines = [];

    // Get only lines (-8 + $line, 8 + $line) where exception was executed
    foreach(explode("\r\n", $content) as $key => $content_line) {
        if($key > $line - 8 && $key < $line + 8) $lines[] = $content_line;
    }
?>

<?php $app->View('components/Top', ['app' => $app]); ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true]); ?>
    <body>
        <div id="cms-app__root" class="exception">
            <div class="exception-topbar">
                <img src="/favicon.ico" alt="" class="exception-logo">

                <h1 class="exception-header">Sapphire Exception</h1>
            </div>

            <div class="exception-content">
                <h2 class="exception-subheader"><?php echo $exception->_message; ?></h2>
                <h2 class="exception-subheader">in file <?php echo $exception->GetFile(); ?> in line <?php echo $exception->GetLine(); ?></h2> 
                
                <?php /* TODO: Get content of exception file and show like 10 lines of code where exception is called */ ?>

                <div class="lines-container">
                    <div class="file-extension">
                        <?php echo $extension ?>
                    </div>

                    <p class="lines">
                        <?php foreach($lines as $key => $code_line): ?>
                            <span class="line <?php echo 6 == $key ? "active" : ""; ?>">

                                <strong class="line-number"><?php echo $key + $line - 6 ?>.</strong> 
                                <?php echo Code::FormatToHTML($code_line) ?>
                            
                            </span>
                        <?php endforeach; ?>
                    </p>
                </div>
                
            </div>

            <div class="exception-footer">
                <?php $app->View('components/Footer') ?>
            </div>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]); ?>