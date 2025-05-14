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
            height: 100vh;
            position: relative;
        }

        .orbit-circle img {
            width: 35px;
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
            width: 550px;
            height: 550px;
            /* animation: spin1 50s linear infinite; */
        }

        .orbit2 {
            width: 650px;
            height: 650px;
            animation: spin2 50s linear infinite;
        }

        .orbit3 {
            width: 550px;
            height: 550px;
            animation: spin1 50s linear infinite;
        }

        .orbit4 {
            width: 450px;
            height: 450px;
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
        .orbit1 .icon1 { top: 0; left: 50%; transform: translate(-50%, -50%); }
        .orbit1 .icon2 { top: 25%; left: 90%; transform: translate(-50%, -50%); }
        .orbit1 .icon3 { top: 75%; left: 90%; transform: translate(-50%, -50%); }
        .orbit1 .icon4 { top: 100%; left: 50%; transform: translate(-50%, -50%); }

        .orbit2 .icon1 { top: 0; left: 50%; transform: translate(-50%, -50%); }
        .orbit2 .icon2 { top: 50%; left: 100%; transform: translate(-50%, -50%); }
        .orbit2 .icon3 { top: 50%; left: 0%; transform: translate(-50%, -50%); }
        .orbit2 .icon4 { top: 100%; left: 50%; transform: translate(-50%, -50%); }

        .orbit3 .icon1 { top: 0%; left: 50%; transform: translate(-50%, -50%); }
        .orbit3 .icon2 { top: 100%; left: 50%; transform: translate(-50%, -50%); }
        .orbit3 .icon3 { top: 47%; left: 100%; transform: translate(-50%, -50%); }
        .orbit3 .icon4 { top: 47%; left: 0%; transform: translate(-50%, -50%); }

        .orbit4 .icon1 { top: 0; left: 50%; transform: translate(-50%, -50%); }
        .orbit4 .icon2 { top: 46%; left: 0%; transform: translate(-50%, -50%); }
        .orbit4 .icon3 { top: 50%; left: 100%; transform: translate(-50%, -50%); }
        .orbit4 .icon4 { top: 100%; left: 50%; transform: translate(-50%, -50%); }

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
            width: 320px;
            line-height: 30px;
            z-index: 99;
        }
    </style>
    
<section id="hero" class="position-relative mt-3">
	<div class="container position-relative zindex-1">
		<?php echo message() ?>
		<div class="row g-lg-5 py-10">
			<div class="col-lg-7 text-center text-lg-start">
				<h1 class="display-4 fw-bolder my-4">
				<strong><?php echo isset(config('theme_config')->homeheader) && !empty(config('theme_config')->homeheader) ? config('theme_config')->homeheader : ee('Intuitive, Secure<br>& Dynamic').'<br> <span class="gradient-primary clip-text" data-toggle="typed" data-list="'.(implode(',', [e('Links').'.',e('QR Codes').'.', e('Bio Pages').'.'])).'"></span>' ?></strong>
				</h1>
				<p class="col-lg-10 fs-5 mb-5">
					<?php echo isset(config('theme_config')->homedescription) && !empty(config('theme_config')->homedescription) ? config('theme_config')->homedescription :  e('Boost your campaigns by creating dynamic Links, QR codes and Bio Pages and get instant analytics.') ?>
				</p>
				<?php message() ?>
				<form method="post" action="<?php echo route('shorten') ?>" data-trigger="shorten-form" class="mt-3 mb-5 border rounded p-3 text-start">
					<div class="input-group input-group-lg align-items-center">
						<input type="text" class="form-control border-0" placeholder="<?php echo e("Paste a long url") ?>" name="url" id="url">
						<div class="input-group-append">
							<?php if(config('user_history') && !\Core\Auth::logged() && $urls = \Helpers\App::userHistory()): ?>
								<button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#userhistory"><i data-bs-toggle="tooltip" title="<?php ee('Your latest links') ?>" class="fa fa-clock-rotate-left"></i></button>
							<?php endif ?>
							<button class="btn btn-warning d-none" type="button"><?php ee('Copy') ?></button>
							<button class="btn btn-primary" type="submit"><?php ee('Shorten') ?></button>
						</div>
					</div>
					<?php if(!config('pro')): ?>
						<a href="#advanced" data-bs-toggle="collapse" class="btn btn-sm btn-primary mb-2 mt-2"><?php ee('Advanced') ?></a>
						<div class="collapse row" id="advanced">
							<div class="col-md-6 mt-3">
								<div class="form-group">
									<label for="custom" class="control-label fw-bold mb-2"><?php ee('Custom') ?></label>
									<input type="text" class="form-control p-2" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group">
									<label for="pass" class="control-label fw-bold mb-2"><?php ee('Password Protection') ?></label>
									<input type="text" class="form-control p-2" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
								</div>
							</div>
						</div>
					<?php endif ?>
					<?php if(!\Core\Auth::logged()) { echo \Helpers\Captcha::display('shorten'); } ?>
				</form>
				<div id="output-result" class="border border-success p-3 rounded d-none mb-3">
					<div class="d-flex align-items-center">
						<div id="qr-result" class="me-2"></div>
						<div id="text-result">
							<p><?php ee('Your link has been successfully shortened. Want to more customization options?') ?></p>
							<a href="<?php echo route('register') ?>" class="btn btn-sm btn-primary"><?php ee('Get started') ?></a>
						</div>
					</div>
				</div>
				<?php if(\Core\DB::plans()->where('free', '1')->where('status', '1')->first()): ?>
					<a href="<?php echo route('register') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-1"><?php ee('Get Started for Free') ?></a>
					<p>
						<ul class="list-unstyled mb-2 text-muted small">
							<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('Start free, upgrade later') ?></li>
							<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('No credit card required') ?></li>
							<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('Easy to use') ?></li>
						</ul>
					</p>
				<?php else: ?>
					<?php if(\Core\DB::plans()->whereNotEqual('trial_days', '0')->first()): ?>
						<a href="<?php echo route('pricing') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-1"><?php ee('Get Started') ?></a>
						<p>
							<ul class="list-unstyled mb-2 text-muted small">
								<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('Start with a free trial') ?></li>
								<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('No credit card required') ?></li>
								<li class="mb-1"><i class="fa fa-check me-2"></i> <?php ee('Easy to use') ?></li>
							</ul>
						</p>
					<?php else: ?>
						<a href="<?php echo route('register') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-5"><?php ee('Get Started') ?></a>
					<?php endif ?>
				<?php endif ?>
			</div>
			<div class="col-md-10 mx-auto col-lg-5 h-100 d-none d-sm-block position-relative">
				<div class="zindex-100 ml-lg-6">
					<?php if (isset($themeconfig->hero) && !empty($themeconfig->hero)): ?>
						<img src="<?php echo uploads($themeconfig->hero) ?>" alt="<?php echo config("title") ?>" class="img-fluid mw-lg-120 rounded-top zindex-100">
					<?php else: ?>
						<img src="<?php echo assets('images/shapes.svg') ?>" class="img-fluid position-absolute top-0 ms-5 end-0 w-100 h-100 animate-float opacity-50 zindex-0 outer-top">
						<div class="position-relative card shadow-0 bg-transparent p-5 border-0 perspective" style="height:500px">
							<div class="position-absolute gradient-primary w-100 top-0 start-0 opacity-75 rounded-3 h-100"></div>
							<div class="p-5 w-100 position-absolute top-50 start-50 translate-middle row">
								
								<!--<div class="col-12 row p-0">-->
								    <div class="col-md-7 px-0">
								        <div class="card border-0 shadow-lg mb-3">
    									<div class="card-body fs-6">
    										<div class="d-flex align-items-center">
    											<i class="fa fa-mobile fs-4"></i>
    											<div class="ms-3">
    												<h6 class="fw-bold mb-0 text-start"><?php ee('Bio Pages') ?></h6>
    											</div>
    											<div class="ms-auto d-none">
    												<span class="fs-6 text-success"><?php $rand = round(mt_rand() / mt_getrandmax() * 3, 2); echo $rand; ?>M <?php ee('Clicks') ?></span>
    											</div>
    										</div>
    									</div>
    								</div>
    								<div class="card border-0 shadow-lg mb-3">
    									<div class="card-body fs-6">
    										<div class="d-flex align-items-center">
    											<i class="fa fa-link fs-5"></i>
    											<div class="ms-3">
    												<h6 class="fw-bold mb-0 text-start"><?php ee('Smart Short Links') ?></h6>
    											</div>
    											<div class="ms-auto d-none">
    												<span class="fs-6 text-success"><?php $rand = round(mt_rand() / mt_getrandmax() * 3, 2); echo $rand; ?>M <?php ee('Clicks') ?></span>
    											</div>
    										</div>
    									</div>
    								</div>
								    </div>
								     <div class="col-md-5 pe-0">
								         <div class="card border-0 shadow-lg mb-3">
        									<div class="card-body fs-6">
        										<div class="text-center">
        											<img src="<?php echo \Helpers\QR::factory('Sample QR', 50, 0)->format('svg')->create('uri') ?>">
        											<div class="ms-3">
        												<h6 class="fw-bold mt-1 mb-0 text-start"><?php ee('QR Codes') ?></h6>
        											</div>
        											<div class="ms-auto d-none">
        												<span class="fs-6 text-success"><?php $rand = round(mt_rand() / mt_getrandmax() * 3, 2); echo $rand; ?>M <?php ee('Clicks') ?></span>
        											</div>
        										</div>
        									</div>
        								</div>
								     </div>
								<!--</div>-->
								
								<div class="card p-3 border-0 shadow-lg">
									<div class="d-flex align-items-center mb-0">
										<h3 class="text-dark h5 fw-bolder mb-0">
											<?php ee('In-Depth Analytics') ?> <span class="fs-6 text-success">+<?php echo rand(10, 80) ?>%</span>
										</h3>
										<span class="fs-6 d-block text-muted ms-auto fw-bold"><?php echo $rand ?>M <?php ee('Clicks') ?></span>
									</div>
									<svg height="auto" class="rounded" viewBox="0 0 2000 1400" xmlns="http://www.w3.org/2000/svg"><path d="M0 1383.803c21-9.972 63-30.067 105-49.86s63-36.615 105-49.107c42-12.492 63 17.422 105-13.354 42-30.777 63-125.032 105-140.528 42-15.495 63 88.592 105 63.05 42-25.543 63-144.923 105-190.761 42-45.838 63-56.416 105-38.43 42 17.987 63 142.285 105 128.363 42-13.92 63-148.434 105-197.97 42-49.534 63-51.791 105-49.705 42 2.086 63 83.56 105 60.136 42-23.425 63-127.997 105-177.258 42-49.262 63-62.948 105-69.05 42-6.102 63 90.824 105 38.54s63-274.834 105-299.962c42-25.13 63 170.32 105 174.318 42 3.999 63-66.754 105-154.324 42-87.57 63-207.459 105-283.526 42-76.068 84-77.45 105-96.811L2000 1400H0Z" fill="rgba(var(--bs-primary-rgb), 1)"/><path d="M0 1383.803c21-9.972 63-30.067 105-49.86s63-36.615 105-49.107c42-12.492 63 17.422 105-13.354 42-30.777 63-125.032 105-140.528 42-15.495 63 88.592 105 63.05 42-25.543 63-144.923 105-190.761 42-45.838 63-56.416 105-38.43 42 17.987 63 142.285 105 128.363 42-13.92 63-148.434 105-197.97 42-49.534 63-51.791 105-49.705 42 2.086 63 83.56 105 60.136 42-23.425 63-127.997 105-177.258 42-49.262 63-62.948 105-69.05 42-6.102 63 90.824 105 38.54s63-274.834 105-299.962c42-25.13 63 170.32 105 174.318 42 3.999 63-66.754 105-154.324 42-87.57 63-207.459 105-283.526 42-76.068 84-77.45 105-96.811" fill="none" stroke="var(--bs-primary)" stroke-width="4"/><g fill="var(--bs-primary)" opacity="0.2"><circle cx="1575" cy="397.907" r="30"/></g><g fill="var(--bs-primary)"><circle cx="105" cy="1333.943" r="8"/><circle cx="210" cy="1284.836" r="8"/><circle cx="315" cy="1271.482" r="8"/><circle cx="420" cy="1130.954" r="8"/><circle cx="525" cy="1194.003" r="8"/><circle cx="630" cy="1003.243" r="8"/><circle cx="735" cy="964.814" r="8"/><circle cx="840" cy="1093.176" r="8"/><circle cx="945" cy="895.207" r="8"/><circle cx="1050" cy="845.501" r="8"/><circle cx="1155" cy="905.637" r="8"/><circle cx="1260" cy="728.379" r="8"/><circle cx="1365" cy="659.329" r="8"/><circle cx="1470" cy="697.869" r="8"/><circle cx="1575" cy="397.907" r="8"/><circle cx="1680" cy="572.225" r="8"/><circle cx="1785" cy="417.901" r="8"/><circle cx="1890" cy="134.375" r="8"/><text x="1480" y="300" class="fw-bold display-2"><?php echo round(mt_rand() / mt_getrandmax() * 2, 2) ?>K</text></g></svg>
								</div>
							</div>
							<!--<div class="card border-0 shadow-lg mb-3 position-absolute top-0 start-0 me-5 animate-float outer-left d-table">-->
							<!--	<div class="card-body">-->
							<!--		<div class="position-relative">-->
							<!--			<div class="border-0 d-block rounded p-1 d-inline-block gradient-primary text-white position-absolute top-0 start-100 translate-middle ms-3">-->
							<!--				<img src="<?php echo \Helpers\QR::factory('Sample QR', 40, 0)->format('svg')->create('uri') ?>" class="rounded">-->
							<!--			</div>-->
							<!--			<h5 class="mb-0 fw-bold me-3 text-start"><?php ee('QR Codes') ?></h5>-->
							<!--		</div>-->
							<!--	</div>-->
							<!--</div>-->
							<!--<div class="card border-0 shadow-lg mb-3 position-absolute top-50 end-0 mt-5 animate-float outer-right d-table">-->
							<!--	<div class="position-relative p-2">-->
							<!--		<span class="shadow-0 rounded p-2 px-3 d-inline-block gradient-primary text-white position-absolute top-0 start-50 translate-middle">-->
							<!--			<i class="fa fa-mobile"></i>-->
							<!--		</span>-->
							<!--		<h5 class="mb-0 mt-3 mx-3 fw-bold text-start"><?php ee('Bio Pages') ?></h5>-->
							<!--	</div>-->
							<!--</div>-->
							<!--<div class="card border-0 shadow-lg mb-3 position-absolute top-100 start-0 ms-5 animate-float outer-left d-table">-->
							<!--	<div class="card-body">-->
							<!--		<div class="d-flex align-items-center">-->
							<!--			<span class="shadow-0 rounded p-2 px-3 d-inline-block gradient-primary text-white me-2">-->
							<!--				<i class="fa fa-link"></i>-->
							<!--			</span>-->
							<!--			<h5 class="mb-0 fw-bold"><?php ee('Smart Short Links') ?></h5>-->
							<!--		</div>-->
							<!--	</div>-->
							<!--</div>-->
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="py-10 pt-5" id="features">
	<div class="container">
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5">
			<div class="col-md-6 offset-md-1 text-start">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Collect data within minutes. Hassle-free.') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mt-3 mb-5">
					<?php ee('One short link, infinite possibilities.') ?>
				</h2>
				<p class="lead mb-5">
					<?php ee('A short link is a powerful marketing tool when you use it carefully. It is not just a link but a medium between your customer and their destination. A short link allows you to collect so much data about your customers and their behaviors.') ?>
				</p>
				<ul class="list-unstyled mb-2">
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-link gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Short Links') ?></span>
								<p><?php ee('Intuitive and trackable links') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-qrcode gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('QR Codes') ?></span>
								<p><?php ee('Customizable and secure QR codes') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-mobile gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Beautiful Bio Pages') ?></span>
								<p><?php ee('Simple yet beautiful Bio Pages for your links') ?></p>
							</div>
						</div>
					</li>
				</ul>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
			<div class="col-md-5">
				<div class="p-4 p-md-5 rounded-3 shadow-sm position-relative h-100 gradient-primary">
					<h6 class="fw-bold text-white mb-2 text-start"><?php ee('Turn long links into short links') ?></h6>
					<h5 class="fw-bold text-white border rounded p-3"><span data-toggle="typed" data-list="<i class='fa fa-times-circle'></i> https://longurl.com/page/article-name,<i class='fa fa-check-circle'></i> <?php echo str_replace('www.', '', url('short')) ?>"></span></h5>
					<div class="position-absolute position-sm-relative card mt-10 top-0 ms-0 ms-md-5 start-0 d-block p-5 rounded shadow w-100 opacity-90 border-0 text-start">
						<h5 class="fw-bold"><?php ee('Where are most of your users located?') ?></h5>
						<div class="mt-4">
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/qa.svg') ?>" class="icon">
							<span class="align-middle ms-2">
								<?php ee('Qatar') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/sa.svg') ?>" class="icon">
							<span class="align-middle ms-2">
								<?php ee('Saudi Arabia') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/ae.svg') ?>" class="icon">
							<span class="align-middle ms-2">
								<?php ee('United Arab Emirates') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/kw.svg') ?>" class="icon">
							<span class="align-middle ms-2">
								<?php ee('Kuwait') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row align-items-center gy-5 py-5 mt-8 text-start">
			<div class="col-md-6 order-last order-sm-first">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Instantly link to apps. Automatically.') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Smart Deep Linking') ?>
				</h2>
				<p class="lead mb-5">
					<?php ee('Grow your audience by automatically opening mobile apps when the app is installed without any coding knowledge or SDK. Direct customers to download and install apps when not installed on the device. Many popular apps are supported and you can even add your own app links.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
			<div class="col-md-6">
				<div class="border rounded p-3 shadow-sm card position-relative">
                    <h5 class="fw-bolder mb-0"><i class="fa fa-lock text-success me-2"></i> <?php echo url() ?><span class="gradient-primary clip-text" >smart</span></h5>
					<span class="gradient-primary d-inline-block position-absolute top-100 start-50 translate-middle text-white rounded-circle icon-sm text-center"><i class="fa fa-chevron-down mt-2 animate-float"></i></span>
                </div>
				<h3 class="h5 fw-bold mt-4 text-center"><?php ee('Popular Apps') ?></h3>
				<div class="row mt-4 justify-content-center">
					<?php foreach(\Helpers\DeepLinks::list() as $item): ?>
						<div class="col-4 col-lg-2 mb-5 text-center">
							<img alt="<?php echo $item['title'] ?>" src="<?php echo $item['icon'] ?>" class="icon-md bg-white shadow-sm p-2 rounded">
							<p class="fw-bold text-dark my-3"><?php echo $item['title'] ?></p>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="bg-primary py-15 text-dark">
  	<div class="container">
		<div class="text-center mb-5 px-3">
			<h2 class="fw-bolder display-5 mb-3"><strong><?php ee("Features that<br>you'll <span class=\"gradient-primary clip-text\">ever need</span>") ?></strong></h2>
			<p class="lead"><?php ee('We provide you with all the tools you need to increase your productivity.') ?></p>
		</div>
		<div class="row gy-4 py-5 mt-sm-5 justify-content-center text-start">
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-spinner fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Custom Landing Page') ?></h4>
						<p>
							<?php ee('Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-layer-group fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('CTA Overlays') ?></h4>
						<p>
							<?php ee('Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-compass fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Event Tracking') ?></h4>
						<p>
							<?php ee('Add your custom pixel from providers such as Facebook and track events right when they are happening.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-bullseye fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Smart Targeting') ?></h4>
						<p>
							<?php ee('Easily apply restrictions to your links and target users in specific countries & languages using specific devices.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
					<i class="fa fa-mouse-pointer fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Track Everything') ?></h4>
						<p>
							<?php ee('Track users with our advanced reporting tool and know exactly which city & country your users are based.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-users fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Team Management') ?></h4>
						<p>
							<?php ee('Invite your team members and assign them specific privileges to manage everything and collaborate together.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-globe fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Branded Domain Names') ?></h4>
						<p>
							<?php ee("Easily add your own domain name for short links and take control of your brand name and your users' trust.") ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-box fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Campaigns & Channels') ?></h4>
						<p>
							<?php ee('Group and organize your Links, Bio Pages and QR Codes. With Campaigns, you can also get aggregated stats.') ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="h-100 card shadow-sm border-0">
					<div class="card-body p-4 p-sm-5">
						<i class="fa fa-terminal fa-2x gradient-primary clip-text"></i>
						<h4 class="fw-bold my-3"><?php ee('Developer API') ?></h4>
						<p>
							<?php ee('Use our powerful API to build custom applications or extend your own application with our powerful tools.') ?>
						</p>
					</div>
				</div>
			</div>
		</div>
  	</div>
</section>
<section class="py-10">
	<div class="container">
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5">
			<div class="col-md-6 order-last order-sm-first" id="notifications-card">
				<div class="card shadow border-0 p-3 mb-4 mt-5 text-start">
					<div class="d-flex">
						<img alt="<?php ee('Saudi Arabia') ?>" src="<?php echo assets('images/flags/sa.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2">
							<h6 class="fw-bold mb-1"><?php ee('Someone scanned your QR Code') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span class="text-muted"><?php ee('Saudi Arabia') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill gradient-primary p-2"><?php ee('{d} minutes ago', null, ['d' => 8]) ?></span>
						</div>
					</div>
				</div>
				<div class="card shadow gradient-primary border-0 p-3 mb-4  text-start">
					<div class="d-flex">
						<img alt="<?php ee('United Arab Emirates') ?>" src="<?php echo assets('images/flags/ae.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2 text-white">
							<h6 class="fw-bold mb-1"><?php ee('Someone visited your Link') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span><?php ee('United Arab Emirates') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill bg-white text-dark p-2"><?php ee('{d} minutes ago', null, ['d' => 5]) ?></span>
						</div>
					</div>
				</div>
				<div class="card shadow border-0 p-3 mb-4  text-start">
					<div class="d-flex">
						<img alt="<?php ee('Qatar') ?>" src="<?php echo assets('images/flags/qa.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2">
							<h6 class="fw-bold mb-1"><?php ee('Someone viewed your Bio Page') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span class="text-muted"><?php ee('Qatar') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill gradient-primary p-2"><?php ee('{d} minutes ago', null, ['d' => 6]) ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 order-first order-sm-last text-start">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Get instant results') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Track & Optimize') ?>
				</h2>
				<p class="lead mb-5 pe-5">
					<?php ee('Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
		</div>
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5 mt-8 text-start">
			<div class="col-md-6 order-first order-sm-last d-none d-md-block">
                    <img src="https://twigs.cc/content/images/9814.jpg" class="w-100">
						
				<div class="memberssec container d-none">
				    
        <!--<span class="join-button"><?php ee('Invite your teammates & work together') ?></span>-->
        <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-f1.svg" alt="عضو 1">
        </div>
        <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-m2.svg" alt="عضو 2">
            <div class="bg-img-color"></div>
        </div>
        <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-m1.svg" alt="عضو 3">
        </div>
        <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-m2.svg" alt="عضو 4">
            <span class="badge badge-pill bg-primary p-2 invited-span"><strong class="gradient-primary clip-text"><?php ee('Invited') ?></strong></span>
        </div>
        <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-f1.svg" alt="عضو 5">
        </div>
         <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-m2.svg" alt="عضو 5">
            <span class="badge badge-pill bg-primary p-2 invited-span"><strong class="gradient-primary clip-text"><?php ee('Invited') ?></strong></span>
        </div>
        
         <div class="profile">
            <img src="https://twigs.cc/static/images/avatar-m1.svg" alt="عضو 5">
        </div>
       
    </div>
				
			</div>
			<div class="col-md-6 order-last order-sm-first">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Collaborate with your teammates') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Invite & Work Together') ?>
				</h2>
				<p class="lead mb-5">
					<?php ee('Invite your teammates within seconds and work together as team to manage your Links, Bio Pages and QR codes. Team members can can be assigned specific privileges and can work on different workspaces.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
		</div>
		
		 <style>
      
    .sa svg {
      width: 89vw;
      height: 100vh;
      display: block;
    }
    .sa .link {
      stroke: #f4b449;
      stroke-width: 2;
      opacity: 0.8;
    }
    .sa .node-image {
      pointer-events: all;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    ."sa" .node-text {
      fill: #333;
      font-size: 14px;
      text-anchor: middle;
      pointer-events: none;
      font-weight: 500;
    }
    .sa #centerBtn {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      background: #f4b449;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 30px;
      cursor: pointer;
      font-family: 'Cairo', sans-serif;
      font-size: 16px;
      font-weight: bold;
      z-index: 10;
      box-shadow: 0 4px 12px rgba(244, 180, 73, 0.3);
      transition: all 0.3s ease;
    }
    .sa #centerBtn:hover {
      transform: translate(-50%, -50%) scale(1.05);
      box-shadow: 0 6px 16px rgba(244, 180, 73, 0.4);
    }
    .sa {
      position: relative;
    }
  </style>
  
		<div class="row mt-10">
			<div class="col-md-12">
				<div class="p-2 p-md-5 bg-primary rounded-4 border-0">
				    
				    <div class="orbit-container">
        <div class="orbit-content">
            <h3 class="fw-bold mt-4"><strong><?php ee('Integrations') ?></strong></h3>
            <p><?php ee('Connect your links to third-party applications so they can share information such as traffic and analytics.') ?></p>
            <a class="btn btn-primary fw-bold" href="https://twigs.cc/ar/user/register" id="centerBtn"><?php ee('Get Started') ?></a>
        </div>
        <div class="orbit-circle">
            <div class="orbit orbit2  d-none d-md-block">
                <div class="icon icon1"><img src="https://twigs.cc/static/images/gtm.svg" alt=""></div>
                <div class="icon icon1"><img src="https://twigs.cc/static/images/slack.svg" alt=""></div>
                <div class="icon icon2"><img src="https://twigs.cc/static/images/reddit.svg" alt=""></div>
                <div class="icon icon3"><img src="https://twigs.cc/static/images/snapchat.svg" alt=""></div>
                <div class="icon icon4"><img src="https://twigs.cc/static/images/linkedin.svg" alt=""></div>
            </div>
    
            <div class="orbit orbit3 d-none d-md-block">
                <div class="icon icon1"><img src="https://twigs.cc/static/images/x.svg" alt="" srcset=""></div>
                <div class="icon icon2"><img src="https://twigs.cc/static/images/quora.svg" alt=""></div>
                <div class="icon icon3"><img src="https://twigs.cc/static/images/wp.svg" alt=""></div>
                <div class="icon icon4"><img src="https://twigs.cc/static/images/tiktok.svg" alt=""></div>
            </div>
    
            <div class="orbit orbit4 d-none d-md-block">
                <div class="icon icon1"><img src="https://twigs.cc/static/images/ga.svg" alt="" srcset=""></div>
                <div class="icon icon2"><img src="https://twigs.cc/static/images/zapier.svg" alt=""></div>
                <div class="icon icon3"><img src="https://twigs.cc/static/images/facebook.svg" alt="" srcset=""></div>
                <div class="icon icon4">
                    <img src="https://twigs.cc/static/images/pinterest.svg" alt="">
                </div>
            </div>
        </div>
        
    </div>
					<div class="row mt-5 text-start">
						<div class="col-md-6 mb-2 mb-md-0">
							<div class="h-100 card shadow-sm border-0">
								<div class="card-body p-4 p-sm-5">
									<i class="fa fa-th fa-2x gradient-primary clip-text"></i>
									<h4 class="fw-bold my-3"><?php ee('Tracking Pixels') ?></h4>
									<p>
										<?php ee('Add your custom pixel from providers such as Facebook & Google Tag Manager and track events right when they are happening.') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 mb-0">
							<div class="h-100 card shadow-sm border-0">
								<div class="card-body p-4 p-sm-5">
									<i class="fa fa-bell fa-2x gradient-primary clip-text"></i>
									<h4 class="fw-bold my-3"><?php ee('Notifications') ?></h4>
									<p>
										<?php ee('Get notified when users use your links via various channels such Slack and webhook services like Zapier.') ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if($testimonials = (array) config('testimonials')): ?>
	<section class="bg-primary">
		<div class="container py-8">
			<div class="row my-5 justify-content-center text-center">
				<div class="col-lg-8 col-md-10">
					<h2 class="mb-2 fw-bolder h1"><strong><?php ee("Don't take our word for it.") ?></strong></h2>
					<h2 class="mb-5 fw-bolder h1"><strong class="gradient-primary clip-text"><?php ee('Trust our customers.') ?></strong></h2>
				</div>
			</div>
			<div class="row">
				<?php foreach(array_chunk($testimonials, ceil(count($testimonials)/3)) as $testimonials): ?>
					<div class="col-lg-4 px-sm-2">
						<?php foreach($testimonials as $testimonial): ?>
							<div class="card shadow-sm border-0 mb-4 mx-lg-1">
								<div class="card-body p-3">
									<p><?php echo $testimonial->testimonial ?></p>
									<div class="d-flex align-items-center mt-3">
										<div>
											<?php if(isset($testimonial->avatar) && file_exists(appConfig('app')['storage']['avatar']['path'].'/'.$testimonial->avatar)) $testimonial->avatar = uploads($testimonial->avatar, 'avatar');else{if($testimonial->email){$testimonial->avatar = 'https://www.gravatar.com/avatar/'.md5(trim($testimonial->email)).'?s=64&d=identicon';}} ?>
											<?php echo $testimonial->avatar ? '<img src="'.$testimonial->avatar.'" class="avatar-sm rounded-circle"" alt="'.$testimonial->name.'">': '' ?>
										</div>
										<div class="ms-3">
											<span class="h6 mb-0"><?php echo $testimonial->name ?>  <?php echo $testimonial->job  ? '<small class="d-block text-muted">'.$testimonial->job.'</small>' : '' ?></span>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</section>
<?php endif ?>
<?php if (config("homepage_stats")): ?>
	<section class="py-8">
        <div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12">
					<h2 class="fw-bolder display-5 mb-5 text-center"><strong>دع <span class="gradient-primary clip-text">الأرقام</span> هي التي تتحدث</strong></h2>
				</div>
				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-4 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Powering') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->links ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Links') ?></h3>
							</div>
						</div>
						<div class="col-md-4 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Serving') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->clicks ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Clicks') ?></h3>
							</div>
						</div>
						<div class="col-md-4 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Trusted by') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->users ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Amazing Customers') ?></h3>
							</div>
						</div>
					</div>
					<div class="row">
						
						<div class="col-md-6 mb-5 d-none d-md-none">
							<a href="<?php echo route('register') ?>">
								<div class="bg-primary py-5 px-2 px-lg-5 rounded h-100 d-flex align-items-center justify-content-center">
									<h3 class="h5 text-capitalize">
										<span class="gradient-primary fw-bolder clip-text"><?php ee('Get Started') ?> <i class="fa fa-chevron-right small"></i></span>
									</h3>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
        </div>
    </section>
<?php endif ?>
<section class="py-5">
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
<?php if(config('user_history') && !\Core\Auth::logged() && $urls = \Helpers\App::userHistory()): ?>
<div class="modal fade" id="userhistory" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title fw-bolder"><?php ee('Your latest links') ?></h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php foreach($urls as $url): ?>
					<h6 class="mb-1"><a href="<?php echo $url['url'] ?>" target="_blank"><?php echo $url['meta_title'] ?></a></h6>
					<a href="<?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?>" class="text-muted d-block mb-3"><?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?></a>
				<?php endforeach ?>
				<div class="d-flex mt-5 border rounded p-2">
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
</div>


<?php endif ?>

<script src="https://d3js.org/d3.v7.min.js"></script>
  <script>
    const svg = d3.select(".sa svg");
    let width = window.innerWidth;
    let height = window.innerHeight;
    const centerX = width / 2;
    const centerY = height / 2;
    const margin = 50;
    const buttonMargin = 40; // هامش حول الزر
    const imageMargin = 30; // هامش بين الصورة والخط

    const nodes = [
      { id: "WordPress", name: "وورد بريس", img: "https://twigs.cc/static/images/wp.svg" },
      { id: "Slack", name: "سلاك", img: "https://twigs.cc/static/images/slack.svg" },
      { id: "Zapier", name: "زابير", img: "https://twigs.cc/static/images/zapier.svg" },
      { id: "Shortcuts", name: "شورت كت", img: "https://twigs.cc/static/images/shortcuts.svg" },
      { id: "Google Tag Manager", name: "جوجل تاج مانجر", img: "https://twigs.cc/static/images/gtm.svg" },
      { id: "X", name: "اكس", img: "https://twigs.cc/static/images/x.svg" },
      { id: "Snapchat", name: "سناب شات", img: "https://twigs.cc/static/images/snapchat.svg" },
      { id: "Facebook", name: "فيسبوك", img: "https://twigs.cc/static/images/facebook.svg" },
      { id: "LinkedIn", name: "لينكد ان", img: "https://twigs.cc/static/images/linkedin.svg" },
      { id: "Adroll", name: "ادرول", img: "https://twigs.cc/static/images/adroll.svg" },
      { id: "Google Analytics", name: "جوجل اناليتكس", img: "https://twigs.cc/static/images/ga.svg" },
      { id: "TikTok", name: "تيك توك", img: "https://twigs.cc/static/images/tiktok.svg" },
      { id: "Reddit", name: "ريدت", img: "https://twigs.cc/static/images/reddit.svg" },
      { id: "Quora", name: "كورا", img: "https://twigs.cc/static/images/quora.svg" },
      { id: "Bing", name: "بينغ", img: "https://twigs.cc/static/images/bing.svg" },
      { id: "Pinterest", name: "بينتريست", img: "https://twigs.cc/static/images/pinterest.svg" },
    ];

    // إنشاء الخطوط المرتبطة بالمركز
    const link = svg.append("g")
      .selectAll("line")
      .data(nodes)
      .enter().append("line")
      .attr("class", "link");

    // إنشاء العقد
    const node = svg.append("g")
      .selectAll("g")
      .data(nodes)
      .enter().append("g")
      .attr("class", "node");

    node.append("image")
      .attr("class", "node-image")
      .attr("xlink:href", d => d.img)
      .attr("width", 30)
      .attr("height", 30)
      .attr("x", -15)
      .attr("y", -15);

    node.append("circle")
      .attr("r", 25)
      .attr("fill", "none")
      .attr("stroke-width", 1)
      .style("opacity", 0);

    node.append("text")
      .attr("class", "node-text")
      .attr("dy", 40)  <!-- تم زيادة المسافة هنا من 30 إلى 50 -->
      .text(d => d.name);

    node.on("mouseover", function(event, d) {
      d3.select(this).select("image")
        .transition().duration(300)
        .attr("width", 40)
        .attr("height", 40)
        .attr("x", -20)
        .attr("y", -20);

      d3.select(this).select("circle")
        .transition().duration(300)
        .attr("r", 30)
        .style("opacity", 1);

      d3.select(this).select("text")
        .transition().duration(300)
        .style("font-size", "16px")
        .attr("dy", 50); 
    }).on("mouseout", function(event, d) {
      d3.select(this).select("image")
        .transition().duration(300)
        .attr("width", 30)
        .attr("height", 30)
        .attr("x", -15)
        .attr("y", -15);

      d3.select(this).select("circle")
        .transition().duration(300)
        .style("opacity", 0);

      d3.select(this).select("text")
        .transition().duration(300)
        .style("font-size", "14px")
        .attr("dy", 40);
    });

    // إعداد محاكاة القوى
    const simulation = d3.forceSimulation(nodes)
      .force("charge", d3.forceManyBody().strength(-200))
      .force("center", d3.forceCenter(centerX, centerY))
      .force("collision", d3.forceCollide().radius(50))
      .velocityDecay(0.8)
      .on("tick", ticked);

    function ticked() {
      // تحديث مواقع الخطوط مع الهوامش
      link.attr("x1", d => {
        const dx = d.x - centerX;
        const dy = d.y - centerY;
        const dist = Math.hypot(dx, dy);
        return dist === 0 ? centerX : centerX + (dx / dist) * buttonMargin;
      })
      .attr("y1", d => {
        const dx = d.x - centerX;
        const dy = d.y - centerY;
        const dist = Math.hypot(dx, dy);
        return dist === 0 ? centerY : centerY + (dy / dist) * buttonMargin;
      })
      .attr("x2", d => {
        const dx = d.x - centerX;
        const dy = d.y - centerY;
        const dist = Math.hypot(dx, dy);
        return d.x - (dx / dist) * imageMargin;  // إضافة هامش بين الصورة والخط
      })
      .attr("y2", d => {
        const dx = d.x - centerX;
        const dy = d.y - centerY;
        const dist = Math.hypot(dx, dy);
        return d.y - (dy / dist) * imageMargin;  // إضافة هامش بين الصورة والخط
      });

      // تقييد الحركة داخل الحدود
      nodes.forEach(d => {
        d.x = Math.max(margin, Math.min(width - margin, d.x));
        d.y = Math.max(margin, Math.min(height - margin, d.y));
      });

      node.attr("transform", d => `translate(${d.x},${d.y})`);
    }

    window.addEventListener("resize", () => {
      width = window.innerWidth;
      height = window.innerHeight;
      svg.attr("width", width).attr("height", height);
      simulation.force("center", d3.forceCenter(width / 2, height / 2));
      simulation.alpha(1).restart();
    });
  </script>