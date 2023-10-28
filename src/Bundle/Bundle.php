<?php
    /**
     * CMS Bundler script
     * ===================================
     * 
     * It combines all .php files,
     * that are required to cms to works 
     * together
     */

    // Including all of liblaries from @/libs
    require_once('../libs/onyx/Requires/Requires.php');

    // Including all of the interfaces
    require_once('../src/Setup/Setup.php');
    require_once('../src/View/Viewable.php');
    require_once('../src/Handle/Handleable.php');
    require_once('../src/Farbic/Farbicable.php');
    require_once('../src/Array/Arrayable.php');

    // Exceptions
    require_once('../src/Exceptions/SapphireException.php');
    require_once('../src/Exceptions/FileNotFoundException.php');
    require_once('../src/Exceptions/DatabaseCannotConnectException.php');
    require_once('../src/Exceptions/CollectionFileNotFoundException.php');
    require_once('../src/Exceptions/LayoutNotExistsException.php');
    require_once('../src/Exceptions/HomePageNotFoundException.php');
    require_once('../src/Exceptions/StyleNotFoundException.php');
    
    // Traits that need to before App
    require_once('../src/Router/Routes/Routes.php');
    require_once('../src/Error/Error.php');
    require_once('../src/Component/ComponentIncluder.php');

    // Including all of the classess
    require_once('../src/App/AppSetup.php');
    require_once('../src/App/AppLock.php');
    require_once('../src/App/AppView.php');
    require_once('../src/App/AppUser.php');
    require_once('../src/App/AppDatabase.php');
    require_once('../src/App/AppRouter.php');
    require_once('../src/App/AppPlugins.php');
    require_once('../src/App/App.php');

    require_once('../src/Database/DatabaseSetup.php');
    require_once('../src/Database/DatabaseTable.php');
    require_once('../src/Database/Database.php');

    require_once('../src/Path/PathConstructor.php');

    require_once('../src/File/FileTypes.php');
    require_once('../src/File/FileStatic.php');
    require_once('../src/File/File.php');
    require_once('../src/File/UploadableFile.php');
    
    require_once('../src/User/UserAccessors.php');
    require_once('../src/User/UserIsNew.php');
    require_once('../src/User/UserRoles.php');
    require_once('../src/User/UserSetup.php');
    require_once('../src/User/UserAuth.php');
    require_once('../src/User/UserGetters.php');
    require_once('../src/User/User.php');

    require_once('../src/Settings/SettingsManager.php');
    
    require_once('../src/View/View.php');
    require_once('../src/Code/Code.php');
    require_once('../src/Auth/Authenticator.php');

    require_once('../src/Minifier/Minifier.php');
    require_once('../src/Minifier/HTMLMinifier.php');

    require_once('../src/Styles/StyleStatic.php');
    require_once('../src/Styles/StyleRenderer.php');
    require_once('../src/Styles/StyleScoper.php');
    require_once('../src/Styles/StyleMinifier.php');
    require_once('../src/Styles/StyleComponent.php');
    require_once('../src/Styles/Style.php');

    require_once('../src/Asset/AssetInjector.php');

    require_once('../src/Locale/Locale.php');

    require_once('../src/Request/Request.php');
    require_once('../src/Response/Response.php');

    require_once('../src/Json/Json.php');
    require_once('../src/Serialize/Serialize.php');

    require_once('../src/Collection/Concerns/SchemaItem.php');
    require_once('../src/Collection/Concerns/Schemas/MixedArray.php');
    require_once('../src/Collection/Concerns/Schemas/Text.php');
    require_once('../src/Collection/Concerns/Schemas/Date.php');
    require_once('../src/Collection/Concerns/Schemas/ShortText.php');
    require_once('../src/Collection/Concerns/Schemas/RichText.php');
    require_once('../src/Collection/Concerns/Schemas/LongText.php');
    require_once('../src/Collection/Concerns/Schemas/Number.php');
    require_once('../src/Collection/Concerns/Schemas/IntNumber.php');
    require_once('../src/Collection/Concerns/Schemas/FloatNumber.php');
    require_once('../src/Collection/Concerns/Schemas/Image.php');
    require_once('../src/Collection/Concerns/Schemas/ImageCollection.php');
    require_once('../src/Collection/Concerns/Schemas/Video.php');
    require_once('../src/Collection/Concerns/Schemas/VideoCollection.php');
    require_once('../src/Collection/Concerns/Schemas/MultimediaCollection.php');

    require_once('../src/Collection/Concerns/SchemaBuilder.php');

    require_once('../src/Collection/CollectionAPI.php');
    require_once('../src/Collection/CollectionInfo.php');
    require_once('../src/Collection/CollectionSchemaInfo.php');
    require_once('../src/Collection/CollectionSchema.php');
    require_once('../src/Collection/CollectionFactory.php');
    require_once('../src/Collection/CollectionEntryFactory.php');
    require_once('../src/Collection/CollectionQueries.php');
    require_once('../src/Collection/CollectionSaver.php');
    require_once('../src/Collection/CollectionUtilities.php');
    require_once('../src/Collection/Collection.php');

    require_once('../src/Compilers/Compilable.php');
    require_once('../src/Compilers/Compiler.php');
    require_once('../src/Compilers/OnyxCompiler.php');

    require_once('../src/Component/Helpers/Styles.php');
    require_once('../src/Component/Helpers/Assets.php');
    require_once('../src/Component/Helpers/Translator.php');

    require_once('../src/Component/ComponentEvents.php');
    require_once('../src/Component/ComponentRenderer.php');
    require_once('../src/Component/Component.php');

    require_once('../src/Layout/LayoutStatic.php');
    require_once('../src/Layout/LayoutModifiers.php');
    require_once('../src/Layout/LayoutSetup.php');
    require_once('../src/Layout/LayoutRenderer.php');
    require_once('../src/Layout/Layout.php');

    require_once('../src/Page/PageStatic.php');
    require_once('../src/Page/PageSerialize.php');
    require_once('../src/Page/PageConstruct.php');
    require_once('../src/Page/PageGetters.php');
    require_once('../src/Page/PageUrl.php');
    require_once('../src/Page/PageSaver.php');
    require_once('../src/Page/PageHome.php');
    require_once('../src/Page/PageModifiers.php');
    require_once('../src/Page/Page.php');

    require_once('../src/API/API.php');
    require_once('../src/API/Controllers/SuperAdmin.php');
    require_once('../src/API/Controllers/Auth.php');
    require_once('../src/API/Controllers/User.php');
    require_once('../src/API/Controllers/Collections.php');
    require_once('../src/API/Controllers/Assets.php');
    require_once('../src/API/Controllers/Pages.php');
    require_once('../src/API/Controllers/Layouts.php');
    require_once('../src/API/Controllers/AppFiles.php');
    require_once('../src/API/Controllers/Disk.php');
    require_once('../src/API/Controllers/Settings.php');
    require_once('../src/API/Controllers/Plugins.php');

    require_once('../src/Router/RouterResource.php');
    require_once('../src/Router/Concerns/RouterPage.php');
    require_once('../src/Router/Concerns/PluginPage.php');
    require_once('../src/Router/RouterSetup.php');
    require_once('../src/Router/RouterAdmin.php');
    require_once('../src/Router/RouterUtils.php');
    require_once('../src/Router/RouterAuth.php');
    require_once('../src/Router/Router.php');

    require_once('../src/Plugin/Helpers/AssetInjector.php');
    require_once('../src/Plugin/Helpers/Sidebar.php');
    require_once('../src/Plugin/Helpers/Router.php');
    require_once('../src/Plugin/PluginConfig.php');
    require_once('../src/Plugin/PluginInitiator.php');
    require_once('../src/Plugin/PluginEvents.php');
    require_once('../src/Plugin/PluginApp.php');
    require_once('../src/Plugin/Plugin.php');
    require_once('../src/Plugin/PluginLoader.php');