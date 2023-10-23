<?php $app->View('components/Top', ['app' => $app]) ?>
    <?php $app->View('Head', ['app' => $app, 'admin' => true]) ?>
    <body>
        <div id="cms-app__root">
            <div class="app-container">
                <Sidebar userString="<?php $app->GetUser()->Out(); ?>" active="home"></Sidebar>

                <div class="app-content-container home">
                    <div class="big-padding-container">
                        
                        <h1 class="big-header" data-aos="fade-up">
                            Welcome <span class="theme"><?php echo $app->GetUser()->GetUsername() ?></span> 👋
                        </h1>
                        
                        <p class="subtext" data-aos="fade-up">
                            Hope you ready to bring your app to next level. <br> With Sapphire it's easier than you could ever imagine
                        </p>

                        <h3 class="quick-header" data-aos="fade-up">Quick overview of app stats</h3>

                        <!--<div class="info-boxes-container">
                            <div class="info-box-vertical" data-aos="fade-up">
                                <InfoBox
                                    title="Sales earnings"
                                    icon="fa-solid fa-dollar"
                                    color="rgb(250, 250, 67)"
                                    :value="GetSalesEarnings()"
                                    link="/admin/sales"
                                    placeholder="Open sales center"
                                ></InfoBox>

                                <p class="info-box-description">
                                    It's really important to analyze your sales to grow your buisness
                                </p>
                            </div>

                            <div class="info-box-vertical" data-aos="fade-up">
                                <InfoBox
                                    title="Ads campain traffic"
                                    icon="fa-solid fa-rectangle-ad"
                                    color="rgb(252, 51, 51)"
                                    :value="'+ 53%'"
                                    link="/admin/advertise"
                                    placeholder="Open ads manager"
                                ></InfoBox>

                                <p class="info-box-description">
                                    Sapphire provides innovative ads system - Uranus. Manage your ad campaings in manager above
                                </p>
                            </div>
                        </div>-->

                        <div class="info-boxes-container">
                
                            <div class="info-box-vertical" data-aos="fade-up">
                                <InfoBox
                                    title="Disk space usage"
                                    icon="fa-solid fa-memory"
                                    color="#0099ff"
                                    :value="GetDiskSpace()"
                                    link="/admin/disk"
                                    placeholder="Open disk managment"
                                ></InfoBox>

                                <p class="info-box-description">
                                    For good application enviroment it's essential to manage it's resources as best as you can.
                                </p>
                            </div>

                        </div>

                    </div>

                    <?php $app->View('components/Footer') ?>
                </div>
            </div>
        </div>
    </body>
<?php $app->View('components/Bottom', ['app' => $app]) ?>