<?php \Sapphire\Plugin\PluginLoader::Fire('onEnable'); ?>

<?php
    use Sapphire\Page\Page;

    $page = Page::Current() ?? Page::Home();
    $layout = $page->GetLayout();

    $options = [ "page" => $page, "app" => $app ];
?>

<?php \Sapphire\Plugin\PluginLoader::Fire('onGenerateStart'); ?>

<!DOCTYPE html>
<html lang="<?php echo $app->GetLocale(); ?>" sapphire-html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Sapphire">

    <?php $layout->RenderHead($options); ?>
    <?php \Sapphire\Plugin\PluginLoader::Fire('onClientHead'); ?>
</head>
<body>
    <?php $layout->RenderBody($options); ?>
    <?php \Sapphire\Plugin\PluginLoader::Fire('onClientBody'); ?>
</body>
</html>

<?php \Sapphire\Plugin\PluginLoader::Fire('onGenerateEnd'); ?>