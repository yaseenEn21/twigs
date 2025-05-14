<section class="slice pt-md-8 pb-5 pt-5 <?php echo themeSettings::config('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="my-5" data-offset-top="#navbar-main">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 pr-lg-5">
                    <h1 class="display-3 <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> font-weight-bolder mb-4">
                        <?php echo themeSettings::config('title') ?>
                    </h1>
                    <div class="lead <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8">
                        <?php echo themeSettings::config('description') ?>
                    </div>
                    <?php message() ?>
                    <form class="mt-5" method="post" action="<?php echo route('shorten') ?>" data-trigger="shorten-form">
                        <div class="input-group input-group-lg mb-3">
                            <input type="text" class="form-control" placeholder="<?php echo e("Paste a long url") ?>" name="url" id="url">
                            <div class="input-group-append">
                                <button class="btn btn-warning d-none" type="button"><?php ee('Copy') ?></button>
                                <button class="btn btn-success" type="submit"><?php ee('Shorten') ?></button>
                            </div>
                        </div>
                        <?php if(!config('pro')): ?>
                            <a href="#advanced" data-toggle="collapse" class="btn btn-xs btn-primary mb-2"><?php ee('Advanced') ?></a>
                            <div class="collapse row" id="advanced">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="custom" class="control-label"><?php ee('Custom') ?></label>
                                        <input type="text" class="form-control" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="pass" class="control-label"><?php ee('Password Protection') ?></label>
                                        <input type="text" class="form-control border-start-0 ps-0" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if(!\Core\Auth::logged()) { echo \Helpers\Captcha::display('shorten'); } ?>
                    </form>
                    <div id="output-result" class="border border-success p-3 rounded d-none">
                        <div class="row">
                            <div id="qr-result" class="col-md-4 p-2"></div>
                            <div id="text-result" class="col-md-8">
                                <p class="<?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('Your link has been successfully shortened. Want to more customization options?') ?></p>
                                <a href="<?php echo route('register') ?>" class="btn btn-sm btn-primary"><?php ee('Get started') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-7 mt-lg-0">
                    <div class="position-relative left-8 left-lg-0 d-none d-lg-block">
                        <figure>
                        <?php if (isset($themeconfig->hero) && !empty($themeconfig->hero)): ?>
                            <img src="<?php echo uploads($themeconfig->hero) ?>" alt="<?php echo config("title") ?>" class="img-fluid mw-lg-120 rounded-top zindex-100">
                        <?php else: ?>
                            <img src="<?php echo assets("images/landing.png") ?>" alt="<?php echo config('title') ?>" class="img-fluid mw-lg-120 rounded-top zindex-100">
                        <?php endif ?>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(config('user_history') && !\Core\Auth::logged() && $urls = \Helpers\App::userHistory()): ?>
    <section class="slice pt-md-8 pb-0 bg-section-secondary">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-section-dark">
                        <div class="card-body">
                            <h4 class="text-white mb-5"><?php ee('Your latest links') ?></h4>
                            <?php foreach($urls as $url): ?>
                                <h6><a href="<?php echo $url['url'] ?>" target="_blank" class="text-white"><?php echo $url['meta_title'] ?></a></h6>
                                <a href="<?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?>"><?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?></a>
                                <hr class="border-primary opacity-5">
                            <?php endforeach ?>
                            <div class="d-flex mt-5 text-white">
                                <div class="opacity-8">
                                    <?php ee('Want more options to customize the link, QR codes, branding and advanced metrics?') ?>
                                </div>
                                <div class="ml-auto">
                                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-xs"><?php ee('Get Started') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php \Helpers\App::ads('resp') ?>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<?php if(config('public_dir')): ?>
    <section class="slice pt-md-8 pb-0 bg-section-secondary">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-section-dark">
                        <div class="card-body">
                            <h4 class="text-white mb-5"><?php ee('Latest links') ?></h4>
                            <?php foreach(\Core\DB::url()->where('public', '1')->orderByDesc('date')->limit(15)->findArray() as $url): ?>
                                <h6><a href="<?php echo $url['url'] ?>" target="_blank" class="text-white"><?php echo $url['meta_title'] ?></a></h6>
                                <a href="<?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?>"><?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?></a>
                                <hr class="border-primary opacity-5">
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php \Helpers\App::ads('resp') ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="slice slice-lg">
        <div class="container pt-6 pt-lg-8">
            <div class="mb-8 text-center">
                <h2><?php ee('One short link, infinite possibilities.') ?></h2>
                <div class="fluid-paragraph mt-3">
                    <p class="lead lh-180">
                        <?php ee('A short link is a powerful marketing tool when you use it carefully. It is not just a link but a medium between your customer and their destination. A short link allows you to collect so much data about your customers and their behaviors.') ?>
                    </p>
                </div>
            </div>
            <div class="row mx-lg-n5 mt-sm-4">
                <div class="col-md-4 px-lg-5">
                    <div class="card bg-primary hover-translate-y-n10 shadow-none border-0">
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="icon bg-white rounded-circle icon-shape shadow">
                                    <i data-feather="target"></i>
                                </div>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5 class="text-white"><?php ee('Smart Targeting') ?></h5>
                                <p class="text-white opacity-8 mb-0">
                                    <?php ee('Target your customers to increase your reach and redirect them to a relevant page. Add a pixel to retarget them in your social media ad campaign to capture them.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-lg-5">
                    <div class="card bg-dark hover-translate-y-n10 shadow-none border-0">
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="icon bg-white rounded-circle icon-shape shadow">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5 class="text-white"><?php ee('In-Depth Analytics') ?></h5>
                                <p class="text-white opacity-8 mb-0">
                                    <?php ee("Share your links to your network and measure data to optimize your marketing campaign's performance. Reach an audience that fits your needs.") ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-lg-5">
                    <div class="card bg-dark-dark hover-translate-y-n10 shadow-none border-0">
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="icon bg-white rounded-circle icon-shape shadow">
                                    <i data-feather="star"></i>
                                </div>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5 class="text-white"><?php ee('Digital Experience') ?></h5>
                                <p class="text-white opacity-8 mb-0">
                                    <?php ee("Use various powerful tools increase conversion and provide a non-intrusive experience to your customers without disengaging them.") ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice">
        <div class="container">
            <div class="my-10">
                <div class="row row-grid justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <h5 class="h3"><?php ee('Perfect for sales & marketing') ?></h5>
                        <p class="lead my-4">
                            <?php ee('Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it.') ?>
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-primary text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-layer-group"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Redirection Tools') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-primary text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Powerful Statistics') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-primary text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Beautiful Profiles') ?></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="card mb-0 mr-lg-5 shadow-sm">
                            <div class="card-body p-2">
                                <img src="<?php echo assets('images/profiles.png') ?>" alt="<?php ee('Perfect for sales & marketing') ?>" class="img-responsive w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-10">
                <div class="row row-grid justify-content-between align-items-center">
                    <div class="col-lg-5">
                        <h5 class="h3"><?php ee('Powerful tools that work') ?></h5>
                        <p class="lead my-4">
                            <?php ee('Our product lets your target your users to better understand their behavior and provide them a better overall experience through smart re-targeting. We provide you many powerful tools to reach them better.') ?>
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-success text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Link Management') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-success text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-user-secret"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Privacy Control') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="icon icon-shape bg-success text-white icon-sm rounded-circle mr-3">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0"><?php ee('Powerful Dashboard') ?></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-0 ml-lg-5 shadow-sm">
                            <div class="card-body p-2">
                                <img src="<?php echo assets('images/filters.png') ?>" alt="<?php ee('Powerful tools that work') ?>" class="img-responsive w-100 py-5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-10">
                <div class="row row-grid justify-content-between align-items-center">
                    <div class="col-lg-6">
                        <div class="card mb-0 mr-lg-5 shadow-sm">
                            <div class="card-body p-2">
                                <img src="<?php echo assets('images/qrcodes.png') ?>" alt="<?php ee('Powerful tools that work') ?>" class="img-responsive w-100 py-5">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <h5 class="h3"><?php ee('QR Codes') ?></h5>
                        <p class="lead my-4">
                            <?php ee('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.') ?>
                        </p>
                        <a href="<?php echo route('register') ?>" class="btn btn-primary my-3">
                            <?php ee('Get Started') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg <?php echo themeSettings::config('homestyle', 'light', 'bg-white border-top', 'bg-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
        <div class="container position-relative zindex-100">
            <div class="row row-grid align-items-center justify-content-between">
                <div class="col-lg-5">
                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="row row-grid align-items-center">
                                <div class="col-lg-8">
                                    <div class="media align-items-center">
                                        <img alt="<?php ee('New York, United States') ?>" src="<?php echo assets('images/flags/us.svg') ?>" class="avatar text-white rounded mr-3">
                                        <div class="media-body">
                                            <h6 class="mb-1"><?php ee('Someone visited your link') ?></h6>
                                            <div class="h6 mb-0 text-sm">
                                                <span class="font-weight-bold"><?php ee('New York, United States') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right d-none d-lg-block">
                                    <span class="badge badge-pill badge-soft-success"><?php ee('{d} minutes ago', null, ['d' => 2]) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="row row-grid align-items-center">
                                <div class="col-lg-8">
                                    <div class="media align-items-center">
                                        <img alt="<?php ee('Paris, France') ?>" src="<?php echo assets('images/flags/fr.svg') ?>" class="avatar text-white rounded mr-3">
                                        <div class="media-body">
                                            <h6 class="mb-1"><?php ee('Someone visited your link') ?></h6>
                                            <div class="h6 mb-0 text-sm">
                                                <span class="font-weight-bold"><?php ee('Paris, France') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right d-none d-lg-block">
                                    <span class="badge badge-pill badge-soft-success"><?php ee('{d} minutes ago', null, ['d' => 5]) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="row row-grid align-items-center">
                                <div class="col-lg-8">
                                    <div class="media align-items-center">
                                        <img alt="<?php ee('London, United Kingdom') ?>" src="<?php echo assets('images/flags/gb.svg') ?>" class="avatar text-white rounded mr-3">
                                        <div class="media-body">
                                            <h6 class="mb-1"><?php ee('Someone visited your link') ?></h6>
                                            <div class="h6 mb-0 text-sm">
                                                <span class="font-weight-bold"><?php ee('London, United Kingdom') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right d-none d-lg-block">
                                    <span class="badge badge-pill badge-soft-success"><?php ee('{d} minutes ago', null, ['d' => 8]) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="media d-flex mb-4">
                        <div class="media-body ml-4">
                            <h2 class="<?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> mt-4"><?php ee('Optimize your marketing strategy') ?></h2>
                            <p class="<?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8">
                                <?php ee('Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it.') ?>
                            </p>
                            <a href="<?php echo route('register') ?>" class="btn btn-primary my-3">
                                <?php ee('Get Started') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-10 mb-6 justify-content-center text-center">
                <div class="col-lg-8 col-md-10">
                    <h2 class="<?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> mt-4"><?php ee('More features than asked for') ?></h2>
                </div>
            </div>
            <div class="row mx-lg-n4">
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-warning text-white mr-4">
                                    <i data-feather="loader"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('Custom Landing Page') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee('Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-primary text-white mr-4">
                                    <i data-feather="layers"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('CTA Overlays') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee('Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-danger text-white mr-4">
                                    <i data-feather="compass"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('Event Tracking') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee('Add your custom pixel from providers such as Facebook and track events right when they are happening.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-success text-white mr-4">
                                    <i data-feather="users"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('Team Management') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee('Invite your team members and assign them specific privileges to manage links, bundles, pages and other features.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-info text-white mr-4">
                                    <i data-feather="globe"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('Branded Domain Names') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee("Easily add your own domain name for short your links and take control of your brand name and your users' trust.") ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-sm">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-warning text-white mr-4">
                                    <i data-feather="terminal"></i>
                                </div>
                            </div>
                            <div>
                                <span class="h6"><?php ee('Robust API') ?></span>
                                <p class="text-sm text-muted mb-0">
                                    <?php ee('Use our powerful API to build custom applications or extend your own application with our powerful tools.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg">
        <div class="container">
            <div class="mb-5 text-center">
                <h3><?php ee('Integrations') ?></h3>
                <div class="fluid-paragraph mt-3">
                    <p class="lead lh-180">
                        <?php ee('Connect with popular tools and boost your productivity.') ?>
                    </p>
                </div>
            </div>
            <div class="hover-blurable">
                <a href="<?php echo route('register') ?>">
                    <div class="blurable-item client-group row justify-content-center">
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Slack" src="<?php echo assets("images/wp.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">WordPress</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Slack" src="<?php echo assets("images/slack.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Slack</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Slack" src="<?php echo assets("images/shortcuts.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Shortcuts</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Google Tag Manager" src="<?php echo assets("images/gtm.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Google Tag Manager</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Facebook Pixels" src="<?php echo assets("images/facebook.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Facebook</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Zapier" src="<?php echo assets("images/zapier.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Zapier</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Bing" src="<?php echo assets("images/bing.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Bing</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Twitter" src="<?php echo assets("images/twitter.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Twitter</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Snapchat" src="<?php echo assets("images/snapchat.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Snapchat</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Reddit" src="<?php echo assets("images/reddit.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Reddit</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Google Analytics" src="<?php echo assets("images/ga.svg") ?>" style="width:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Google Analytics</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="LinkedIn" src="<?php echo assets("images/linkedin.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">LinkedIn</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Pinterest" src="<?php echo assets("images/pinterest.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Pinterest</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Quora" src="<?php echo assets("images/quora.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Quora</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="TikTok" src="<?php echo assets("images/tiktok.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">TikTok</p>
                        </div>
                        <div class="client col-lg-2 col-md-3 col-4 py-3 text-center mb-3">
                            <img alt="Adroll" src="<?php echo assets("images/aroll.svg") ?>" style="height:50px">
                            <p class="font-weight-bold <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?> my-3">Adroll</p>
                        </div>
                    </div>
                    <span class="blurable-hidden btn btn-sm btn-primary"><?php ee('Get Started') ?></span>
                </a>
            </div>
        </div>
    </section>
    <?php if($testimonials = config('testimonials')): ?>
        <section class="slice bg-section-secondary">
            <div class="container">
                <div class="row my-5 justify-content-center text-center">
                    <div class="col-lg-8 col-md-10">
                        <h2 class="mt-4"><?php ee('What our customers say about us') ?></h2>
                    </div>
                </div>
                <div class="row mx-n2">
                    <?php foreach($testimonials as $testimonial): ?>
                        <div class="col-md-4 px-sm-2">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body p-3">
                                    <p><?php echo $testimonial->testimonial ?></p>
                                    <div class="d-flex align-items-center mt-3">
                                        <div>
                                            <?php if(isset($testimonial->avatar) && file_exists(appConfig('app')['storage']['avatar']['path'].'/'.$testimonial->avatar)) $testimonial->avatar = uploads($testimonial->avatar, 'avatar');else{if($testimonial->email){$testimonial->avatar = 'https://www.gravatar.com/avatar/'.md5(trim($testimonial->email)).'?s=64&d=identicon';}} ?>
											<?php echo $testimonial->avatar ? '<img src="'.$testimonial->avatar.'" class="avatar avatar rounded-circle bg-warning text-white"" alt="'.$testimonial->name.'">': '' ?>
                                        </div>
                                        <div class="pl-3">
                                            <span class="h6 text-sm mb-0"><?php echo $testimonial->name ?>  <?php echo $testimonial->job  ? "<small class=\"opacity-8 d-block\">{$testimonial->job}</small>" : "" ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    <?php endif ?>
    <?php if (config("homepage_stats")): ?>
    <section class="py-lg-6 bg-section-secondary">
        <div class="container pt-4 position-relative zindex-100">
            <div class="row mt-4">
                <div class="col-lg-12 mx-auto">
                    <div class="row">
                        <div class="col-lg-4 col-6 mb-5 mb-lg-0">
                            <div class="text-center">
                                <h3 class="h5 text-capitalize text-primary"><?php ee('Powering') ?></h3>
                                <div class="h1 text-primary">
                                    <span class="counter"><?php echo $count->links ?></span>
                                    <span class="counter-extra">+</span>
                                </div>
                                <h3 class="h6 text-capitalize"><?php ee('Links') ?></h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mb-5 mb-lg-0">
                            <div class="text-center">
                                <h3 class="h5 text-capitalize text-primary"><?php ee('Serving') ?></h3>
                                <div class="h1 text-primary">
                                    <span class="counter"><?php echo $count->clicks ?></span>
                                    <span class="counter-extra">+</span>
                                </div>
                                <h3 class="h6 text-capitalize"><?php ee('Clicks') ?></h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mb-5 mb-lg-0">
                            <div class="text-center">
                                <h3 class="h5 text-capitalize text-primary"><?php ee('Trusted by') ?></h3>
                                <div class="h1 text-primary">
                                    <span class="counter"><?php echo $count->users ?></span>
                                    <span class="counter-extra">+</span>
                                </div>
                                <h3 class="h6 text-capitalize"><?php ee('Happy Customers') ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif ?>
<?php endif ?>