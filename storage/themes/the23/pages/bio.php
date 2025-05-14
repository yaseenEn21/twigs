
<style>
        /* التصميم العام */
        .order-sm-last.backdrop-cards:before {
            background: linear-gradient(135deg, var(--bs-primary) 0, var(--bs-secondary) 100%) !important;
        }
        .memberssec.container {
            position: relative;
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .memberssec .join-button {
            /*width: 100px;*/
            /*height: 100px;*/
            color: white;
            display: none;
            border-radius: 50%;
            font-size: 16px;
            /*cursor: pointer;*/
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 2;
            transition: transform 0.3s ease;
        }

        .memberssec .profile {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            position: absolute;
            transition: all 0.5s ease;
        }
        
        .memberssec .profile img {
            border: 2px solid white;
        }
        
        
        .invited-span {
            position: absolute;
            left: -20px;
            top: 8px;
        }

        .memberssec .profile img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* لجعل الصورة تملأ الدائرة */
            border-radius: 50%;
        }

        /* تحديد مواقع الصور بشكل دائري */
        .memberssec .profile:nth-child(1) {
    top: 60%;
    left: 54%;
    transform: translateX(-50%) translateY(-100%);
    width: 70px;
    height: 70px;
}

        .memberssec .profile:nth-child(2) {
            top: 68%;
            left: 105%;
            transform: translateY(-50%) translateX(-50%);
            width: 105px;
            height: 105px;
        }

        .memberssec .profile:nth-child(3) {
            top: 79%;
            left: 27%;
            transform: translateX(-50%) translateY(0%);
            width: 95px;
            height: 95px;
        }

        .memberssec .profile:nth-child(4) {
            top: 54%;
            left: 15px;
            transform: translateY(-50%) translateX(-50%);
            width: 80px;
            height: 80px;
        }

        .memberssec .profile:nth-child(5) {
            top: 10%;
            left: 8%;
            transform: translate(-50%, -50%);
            width: 110px;
            height: 110px;
        }

        .memberssec .profile:nth-child(6) {
            top: 4%;
            left: 90%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
        }
        
        .memberssec .profile:nth-child(7) {
            top: 30%;
            left: 145%;
            transform: translate(-50%, -50%);
            width: 85px;
            height: 85px;
        }

        /* تأثير الـ hover على الزر */

        .memberssec .join-button:hover ~ .profile:nth-child(2),
        .memberssec .join-button:hover ~ .profile:nth-child(3),
        .memberssec .join-button:hover ~ .profile:nth-child(4),
        .memberssec .join-button:hover ~ .profile:nth-child(5),
        .memberssec .join-button:hover ~ .profile:nth-child(6)
        {
            /*scale: 1.1;*/
            /*transition: 1s;*/
        }
        
        @media (max-width: 400px) {
            .memberssec .profile:nth-child(7) {
                top: 40%;
                left: 98%;
            }
            
            .memberssec .profile:nth-child(2) {
                top: 82%;
                left: 85%;
            }
            
            .memberssec .profile:nth-child(6) {
                top: 4%;
                left: 65%;
            }
            
        }
        
        /* ---- */
        
        .orbit-container {
            position: relative;
        }
        .orbit-circle {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
            position: relative;
        }

        .orbit-circle img {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 50%;
            padding: 4px;
        }

        .orbit {
            position: absolute;
            border: 2px solid #111;
            border-radius: 50%;
        }

        .orbit1 {
            width: 1150px;
            height: 1150px;
            animation: spin1 50s linear infinite; 
        }

        .orbit2 {
            width: 950px;
            height: 950px;
            animation: spin2 50s linear infinite;
        }

        .orbit3 {
            width: 750px;
            height: 750px;
            animation: spin1 50s linear infinite;
        }

        .orbit4 {
            width: 550px;
            height: 550px;
            animation: spin2 50s linear infinite;
        }

        .orbit-circle .icon {
            position: absolute;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            font-size: 20px;
            transition: transform 0.3s ease;
        }
        
        .orbit .icon img {
            
            animation: counter-spin 50s linear infinite;
        }

        /* عكس دوران الأيقونات للحلقات العادية */
        @keyframes counter-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }

        /* عكس دوران الأيقونات للحلقة الثانية التي تدور بشكل معكوس */
        .orbit2 .icon img {
            animation: reverse-counter-spin 50s linear infinite;
        }

        @keyframes reverse-counter-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .orbit4 .icon img {
            animation: reverse-counter-spin 50s linear infinite;
        }

        /* تحديد مواقع الأيقونات على الحلقات */
        .orbit1 .icon1 { top: 9%; left: 20%; transform: translate(-50%, -50%); }
        .orbit1 .icon2 { top: 10%; left: 81%; transform: translate(-50%, -50%); }
        .orbit1 .icon3 { top: 47%; left: 100%; transform: translate(-50%, -50%); }
        .orbit1 .icon4 { top: 47%; left: 0%; transform: translate(-50%, -50%); }
         .orbit1 .icon5 { top: 88%; left: 83%; transform: translate(-50%, -50%); }
          .orbit1 .icon6 { top: 88%; left: 18%; transform: translate(-50%, -50%); }

        .orbit2 .icon1 { top: 25%; left: 7%; transform: translate(-50%, -50%); }
        .orbit2 .icon2 { top: 0%; left: 50%; transform: translate(-50%, -50%); }
        .orbit2 .icon3 { top: 25%; left: 94%; transform: translate(-50%, -50%); }
        .orbit2 .icon4 { top: 100%; left: 50%; transform: translate(-50%, -50%); }
        .orbit2 .icon5 { top: 70%; left: 96%; transform: translate(-50%, -50%); }
        .orbit2 .icon6 { top: 73%; left: 6%; transform: translate(-50%, -50%); }

        .orbit3 .icon1 { top: 9%; left: 20%; transform: translate(-50%, -50%); }
        .orbit3 .icon2 { top: 10%; left: 81%; transform: translate(-50%, -50%); }
        .orbit3 .icon3 { top: 47%; left: 100%; transform: translate(-50%, -50%); }
        .orbit3 .icon4 { top: 47%; left: 0%; transform: translate(-50%, -50%); }
         .orbit3 .icon5 { top: 88%; left: 83%; transform: translate(-50%, -50%); }
          .orbit3 .icon6 { top: 88%; left: 18%; transform: translate(-50%, -50%); }

        .orbit4 .icon1 { top: 25%; left: 7%; transform: translate(-50%, -50%); }
        .orbit4 .icon2 { top: 0%; left: 50%; transform: translate(-50%, -50%); }
        .orbit4 .icon3 { top: 25%; left: 94%; transform: translate(-50%, -50%); }
        .orbit4 .icon4 { top: 100%; left: 50%; transform: translate(-50%, -50%); }
        .orbit4 .icon5 { top: 70%; left: 96%; transform: translate(-50%, -50%); }
        .orbit4 .icon6 { top: 73%; left: 6%; transform: translate(-50%, -50%); }

        @keyframes spin1 {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spin2 {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }

        .orbit-content {
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            transform: translate(-50%, -50%);
            width: 450px;
            line-height: 30px;
            z-index: 99;
        }
    </style>
<section id="hero" class="position-relative py-4">
    <img src="<?php echo assets('images/shapes.svg') ?>" class="img-fluid position-absolute top-0 start-0 w-100 h-100 animate-float opacity-50 zindex-0">
    <div class="container position-relative" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-4 text-start">
                    <?php ee('Bio Pages') ?>
                </h1>
                <p class="lead opacity-8 pe-5 text-start">
                    <?php ee('Convert your followers by creating beautiful pages that group all of your important links on the single page.') ?>
                </p>
                <div class="border rounded p-3 shadow-sm card mt-3 col-md-8">
                    <h5 class="fw-bolder mb-0" dir="ltr"><?php echo url() ?><span class="gradient-primary clip-text" data-toggle="typed" data-list="<?php echo implode(',', [e('company'),e('shop'), e('name')]) ?>"></span></h5>
                </div>
                <p class="my-5 text-start">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary px-5 py-3 fw-bold"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact', ['subject' => 'Contact Sales']) ?>" class="btn btn-transparent text-dark fw-bold"><?php ee('Contact sales') ?></a>
                </p>
            </div>
            <div class="col-md-5 text-center">

                <div class="card gradient-primary border-0 shadow p-5">
                    <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-f1.svg') ?>" class="img-fluid rounded-circle"></span>
                    <h3 class="text-white fw-bold"><span><?php echo config('title') ?></span></h3></em>
                    <div id="social" class="text-center mt-2">
                        <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        
                        <a href="<?php echo config('snapchat') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Snapchat"><i class="fab fa-snapchat-ghost"></i></a>
                        <a href="<?php echo config('Tiktok') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Tiktok"><i class="fab fa-tiktok"></i></a>
                    </div>
                    <div id="content" class="mt-5">
                        <div class="item mb-3">
                            <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🛒<?php ee('New Merch') ?></a>
                        </div>
                        <div class="item mb-3">
                            <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🔥<?php ee('Shop') ?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container">
        <div class="row row-grid justify-content-between align-items-center">

            <div class="col-lg-5 order-lg-2 text-start">
                <h5 class="h3 fw-bold"><?php ee('One link to rule them all') ?>.</h5>
             
              
	<div class="row">
		<?php foreach($bios as $bio): ?>
			<div class="col-md-4 mb-3">
				<div class="card p-3 h-100 shadow-sm">
					<div class="d-block d-md-flex justify-content-center">						
						<div class="flex-grow-1">
							<div class="position-absolute end-0">
								<button type="button" class="btn btn-default bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
								<ul class="dropdown-menu">
									<?php if(user()->teamPermission('bio.edit')): ?>
										<li><a class="dropdown-item" href="<?php echo route('bio.edit', [$bio->id]) ?>" class="align-middle"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
									<?php endif ?>
									<li><a class="dropdown-item" href="<?php echo route('stats', [$bio->urlid]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
									<li><a class="dropdown-item" href="<?php echo $bio->url ?>"><i data-feather="eye"></i> <?php ee('View Bio') ?></a></li>
									<?php if(user()->defaultbio != $bio->id): ?>
									<li><a class="dropdown-item" href="<?php echo route('bio.default', [$bio->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Set as Default') ?></a></li>
									<?php endif ?>
									<?php if(user()->has('qr')): ?>
										<li><a class="dropdown-item" href="<?php echo route('qr.create', ['url' => $bio->url]) ?>"><i data-feather="aperture"></i> <?php ee('Custom QR Code') ?></a></li>
									<?php endif ?>
									<?php if(user()->teamPermission('bio.edit')): ?>
										<li><a class="dropdown-item" href="#" data-id="<?php echo $bio->id ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#channelModal" data-toggle="addtochannel"><i data-feather="package"></i> <?php ee('Add to Channel') ?></a></li>
										<li><a class="dropdown-item" href="<?php echo route('links.reset', [$bio->urlid, \Core\Helper::nonce('link.reset')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#resetModal"><i data-feather="rotate-ccw"></i> <?php ee('Reset Stats') ?></a></li>
										<li><a class="dropdown-item" href="<?php echo route('bio.duplicate', [$bio->id]) ?>"><i data-feather="copy"></i> <?php ee('Duplicate') ?></a></li>
									<?php endif ?>
									<?php if(user()->teamPermission('bio.delete')): ?>
									<li class="dropdown-divider"></li>
									<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('bio.delete', [$bio->id, \Core\Helper::nonce('bio.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
									<?php endif ?>
								</ul>
							</div>
							<div class="text-center">
								<img src="<?php echo $bio->avatar ?>" class="avatar-lg rounded-circle border p-2 m-0" alt=""><br>
								<div class="mt-2">

									<a href="<?php echo $bio->url ?>" target="_blank"><strong><?php echo $bio->name ?: 'n\a' ?></strong></a>
									<div class="mt-1">
										<small class="text-muted fs-6" data-href="<?php echo $bio->url ?>"><?php echo $bio->url ?></small>
										<a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $bio->url ?>"><small><?php echo e("Copy")?></small></a>
									</div>									
								</div>
							</div>							
							<?php if($channels = $bio->channels): ?>
								<div class="mt-3">
								<?php foreach($channels as $channel): ?>
									<small class="badge text-xs me-2 p-1 px-2 border" style="border-color: <?php echo $channel->color ?>!important;color: <?php echo $channel->color ?>"><?php echo $channel->name ?> <a href="<?php echo route('channel.removefrom', [$channel->id, 'bio', $bio->id]) ?>" class="ms-2 text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Remove from channel') ?>">X</a></small>
								<?php endforeach ?>
								</div>
							<?php endif ?>
							<div class="border p-2 rounded mt-4">
								<?php echo (user()->defaultbio == $bio->id ? '<span class="badge bg-primary me-2">'.e('Default').'</span>' : '') ?>
								<?php if($bio->status == '0') : ?>
									<span class="badge bg-danger me-2"><?php ee('Disabled') ?></span>
								<?php endif ?>
								<?php if(isset($bio->views)):?>
									<i data-feather="eye"></i> <span class="align-middle ms-1 me-2"><?php echo $bio->views .' '.e('Views') ?></span>
								<?php endif ?>
								<i data-feather="clock"></i> <span class="align-middle ms-1"><?php echo \Core\Helper::timeago($bio->created_at) ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<div class="mt-4 d-block">
		<?php echo pagination('pagination justify-content-center border rounded p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
	</div>
                <p class="lead my-4">
                    <?php ee('Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page.') ?>
                </p>
                <ul class="list-unstyled mb-2">
                    <li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-grip gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('{n}+ Dynamic Widgets', null, ['n' => count($widgets)]) ?></span>
								<p><?php ee('Enhance your Bio Page with our dynamic widgets') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-droplet gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Customizable Design') ?></span>
								<p><?php ee('Customize everything with our easy to use builder') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-sliders gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Advanced Settings') ?></span>
								<p><?php ee('Configure your Bio Page & blocks your way') ?></p>
							</div>
						</div>
					</li>
				</ul>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="position-relative d-none d-sm-block">
                    <div class="card bg-danger border-0 shadow p-5 position-absolute w-50 h-80 start-0 my-5">

                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-m2.svg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span><?php ee('Bio Page') ?></span></h3></em>

                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>                        
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fa fa-music position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Listen') ?></a>
                            </div>

                        </div>                        
                    </div>
                    <div class="card gradient-secondary border-0 shadow p-5 position-absolute w-50 h-80 my-5 end-0 top-0">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-m1.svg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span><?php ee('Bio Page') ?></span></h3></em>

                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-youtube position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Subscribe') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg gradient-primary border-0 shadow p-4 w-50 position-relative ms-auto me-auto">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-f1.svg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span><?php ee('Bio Page') ?></span></h3></em>
                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-youtube position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Subscribe') ?></a>
                            </div>
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-tiktok position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Our videos') ?></a>
                            </div>
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-instagram position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Follow us') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-grid justify-content-between align-items-center mt-10">
            <div class="col-lg-5 text-start">
                <h5 class="h3 fw-bold"><?php ee('Trackable to the dot') ?>.</h5>
                <p class="lead my-4">
                <?php ee('Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
            </div>
        </div>
    </div>
</section>
<section class="mb-5">
    <div class="container">
        <div class="p-2 p-md-5 bg-primary rounded-4 border-0" style="overflow: hidden">
            <div class="text-center my-5 d-none">
                <h2 class="fw-bolder display-6 mb-3"><strong><?php ee("Connect with your <span class=\"gradient-primary clip-text\">audience</span>") ?></strong></h2>
                <p class="lead"><?php ee('Add widgets from popular providers and enhance your Bio Page with dynamic content') ?></p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold mt-3"><?php ee('Get Started') ?></a>
            </div>
            <div class="d-none text-center">
                <?php foreach($widgets as $widget): ?>
                    <?php if(strpos($widget['icon'], '<img') === false) continue; ?>
                    <div class="mb-5 mx-5 d-inline-block text-center">
                        <?php echo str_replace('<img', '<img class="icon-md bg-white shadow-sm p-2 rounded-circle"', $widget['icon']) ?>
                        <span class="fw-bold text-dark my-3 d-block"><?php echo $widget['title'] ?></span>
                    </div>
                <?php endforeach ?>
            </div>            
            <div class="orbit-container">
                        <div class="orbit-content">
                            <h2 class="fw-bolder display-6 mb-3"><strong><?php ee("Connect with your <span class=\"gradient-primary clip-text\">audience</span>") ?></strong></h2>
                                <p class="lead"><?php ee('Add widgets from popular providers and enhance your Bio Page with dynamic content') ?></p>
                                <a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold mt-3"><?php ee('Get Started') ?></a>
                        </div>
                        <div class="orbit-circle">
                            <div class="orbit orbit1 d-none d-md-block">
    <div class="icon icon1"><img src="https://twigs.cc/static/images/paypal.svg" alt=""></div>
    <div class="icon icon2"><img src="https://twigs.cc/static/images/whatsapp.svg" alt=""></div>
    <div class="icon icon3"><img src="https://twigs.cc/static/images/youtube.svg" alt=""></div>
    <div class="icon icon4"><img src="https://twigs.cc/static/images/spotify.svg" alt=""></div>
    <div class="icon icon5"><img src="https://twigs.cc/static/images/itunes.svg" alt=""></div>
    <div class="icon icon6"><img src="https://twigs.cc/static/images/maps.svg" alt=""></div>
</div>
<div class="orbit orbit2 d-none d-md-block">
    <div class="icon icon1"><img src="https://twigs.cc/static/images/opentable.svg" alt=""></div>
    <div class="icon icon2"><img src="https://twigs.cc/static/images/typeform.svg" alt=""></div>
    <div class="icon icon3"><img src="https://twigs.cc/static/images/pinterest.svg" alt=""></div>
    <div class="icon icon4"><img src="https://twigs.cc/static/images/reddit.svg" alt=""></div>
    <div class="icon icon5"><img src="https://twigs.cc/static/images/tiktok.svg" alt=""></div>
    <div class="icon icon6"><img src="https://twigs.cc/static/images/opensea.svg" alt=""></div>
</div>

<div class="orbit orbit3 d-none d-md-block">
    <div class="icon icon1"><img src="https://twigs.cc/static/images/twitter.svg" alt=""></div>
    <div class="icon icon2"><img src="https://twigs.cc/static/images/soundcloud.svg" alt=""></div>
    <div class="icon icon3"><img src="https://twigs.cc/static/images/facebook.svg" alt=""></div>
    <div class="icon icon4"><img src="https://twigs.cc/static/images/instagram.svg" alt=""></div>
    <div class="icon icon5"><img src="https://twigs.cc/static/images/eventbrite.svg" alt=""></div>
    <div class="icon icon6"><img src="https://twigs.cc/static/images/snapchat.svg" alt=""></div>
</div>

<div class="orbit orbit4 d-none d-md-block">
    <div class="icon icon1"><img src="https://twigs.cc/static/images/threads.svg" alt="" srcset=""></div>
    <div class="icon icon2"><img src="https://twigs.cc/static/images/tiktok.svg" alt=""></div>
    <div class="icon icon3"><img src="https://twigs.cc/static/images/linkedin.svg" alt="" srcset=""></div>
    <div class="icon icon4"><img src="https://twigs.cc/static/images/calendly.svg" alt="" srcset=""></div>
    <div class="icon icon5"><img src="https://twigs.cc/static/images/whatsapp.svg" alt="" srcset=""></div>
    <div class="icon icon6"><img src="https://twigs.cc/static/images/opensea.svg" alt=""></div>
</div>
                        </div>
                        
                    </div>
            
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="h-100 p-5 gradient-primary text-white with-shapes rounded-4 border-0 text-start">
			<div class="row align-items-center gy-lg-5">
				<div class="col-sm-8">
					<h2 class="fw-bold"><?php ee('Take control of your links') ?></h2>
					<p><?php ee('You are one click away from taking control of all of your links, and instantly get better results.') ?></p>
				</div>
				<div class="col-sm-4 text-end">
					<a class="btn btn-light text-primary btn-lg d-block d-sm-inline-block" href="<?php echo route('register') ?>"><?php ee('Get Started') ?></a>
				</div>
			</div>
		</div>
    </div>
</section>