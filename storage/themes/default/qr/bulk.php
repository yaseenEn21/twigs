<h1 class="h3 mb-5 fw-bold"><?php ee('Create QR in Bulk') ?></h1>

<form action="<?php echo route('qr.savebulk') ?>" data-trigger="saveqr" method="post" enctype="multipart/form-data">
    <?php echo csrf() ?>
    <input type="hidden" name="type" value="text">
    <div class="row">
        <div class="col-md-7">
            <div class="card card-body shadow-sm">
                <div class="form-group">
                    <label class="form-label fw-bold"><?php ee('QR Code Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" placeholder="e.g. For Instagram">
                </div>
                <div class="form-group input-select mt-4">
                    <label class="form-label fw-bold"><?php ee('Domain') ?></label>
                    <select name="domain" id="domain" class="form-select p-2" data-toggle="select">
                        <?php foreach($domains as $domain): ?>
                            <option value="<?php echo $domain ?>"><?php echo $domain ?></option>
                        <?php endforeach ?>
                    </select>
                    <p class="form-text"><?php ee('Choose domain to generate the link with when using dynamic QR codes. Not applicable for static QR codes.') ?></p>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><?php ee('Static QR') ?> <i class="fa fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" title="<?php ee('Static QR codes cannot be tracked.') ?>"></i></h5>
                    <a class="btn border p-2 rounded-3 mb-2 me-1 border-primary active" data-trigger="switcher" href="#text"><i class="me-2" data-feather="type"></i> <?php ee('Text') ?></a>                    

                    <h5 class="card-title fw-bold my-3 mt-4"><?php ee('Dynamic QR') ?> <i class="fa fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" title="<?php ee('With dynamic QR codes, you can track things like location, browser and device when a user scans the QR code.') ?>"></i></h5>
                    <a class="btn border p-2 rounded-3 mb-2 me-1" data-trigger="switcher" href="#link"><i class="me-2" data-feather="link"></i> <?php ee('Link') ?></a>
                </div>
            </div>
            <div class="card shadow-sm" id="qrbuilder">
                <input type="hidden" name="text" value="Sample QR code in here">
                <input type="hidden" name="link" value="<?php echo url('/sample-qr-code') ?>">
                <div class="card-body">
                    <p><?php ee('You can generate QR codes in bulk either by entering data manually or by importing a CSV file. In both cases, you need to format your data one per line. Please note that the maximum amount of QR codes on your account {l} still applies.', null, ['l' => '<strong>('.(user()->hasLimit('qr') > 0 ? user()->hasLimit('qr') : e('Unlimited')).')</strong>']) ?></p>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold"><?php ee('Content') ?></label>
                        <textarea class="form-control" name="content" placeholder="<?php ee('One per line') ?>" rows="10"></textarea>
                    </div> 
                    
                    <div class="form-group">
                        <label class="form-label fw-bold"><?php ee('Upload CSV (max {s}mb)', null, ['s' => round(appConfig('app.sizes')['qrcsv'] /1024, 0)]) ?></label>
                        <input type="file" class="form-control" name="file">
                    </div> 
                </div>
            </div>
            <div class="card shadow-sm">
				<div class="card-header mt-2">
                    <a href="" data-bs-toggle="collapse" class="text-decoration-none" role="button" data-bs-target="#colors"><h5 class="card-title fw-bold"><i class="fa fa-tint fa-lg me-3"></i> <span class="align-middle"><?php ee('Colors') ?></span></h5></a>
				</div>
				<div class="card-body collapse" id="colors">
                    <?php if(\Helpers\QR::hasImagick()): ?>
                    <div class="mb-3">
                        <div class="d-flex bg-light p-2 rounded-3" data-toggle="multibuttons">
                            <a href="#singlecolor" class="btn flex-fill shadow-sm bg-white border rounded-3 fw-bold active" data-trigger="color" data-bs-parent="#colors"><?php ee('Single Color') ?></a>
                            <a href="#gradient" class="btn flex-fill" data-trigger="color" data-bs-parent="#colors"><?php ee('Gradient Color') ?></a>
                        </div>
                    </div>
                    <?php endif ?>
                    <div id="singlecolor" class="collapse show p-3 border rounded mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                    <input type="text" name="bg" id="bg" value="rgb(255,255,255)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold" for="fg"><?php ee("Foreground") ?></label><br>
                                    <input type="text" name="fg" id="fg" value="rgb(0,0,0)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div id="gradient" class="collapse p-3 border rounded mb-3">
                            <input type="hidden" name="mode" value="simple">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                        <input type="text" name="gradient[bg]" id="gbg" value="rgb(255,255,255)">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col form-group mb-3">
                                            <label class="form-label fw-bold" for="fg"><?php ee("Gradient Start") ?></label><br>
                                            <input type="text" name="gradient[start]" id="gfg" value="rgb(0,0,0)">
                                        </div>
                                        <div class="col form-group mb-3">
                                            <label class="form-label fw-bold" for="fgs"><?php ee("Gradient Stop") ?></label><br>
                                            <input type="text" name="gradient[stop]" id="gfgs" value="rgb(0,0,0)">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="fgd"><?php ee("Gradient Direction") ?></label><br>
                                        <select name="gradient[direction]" id="gfgd" class="form-select">
                                            <option value="vertical"><?php ee('Vertical') ?></option>
                                            <option value="horizontal"><?php ee('Horizontal') ?></option>
                                            <option value="radial"><?php ee('Radial') ?></option>
                                            <option value="diagonal"><?php ee('Diagonal') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 rounded border">
                            <div class="col form-group mb-3">
                                <label class="form-label fw-bold"><?php ee("Eye Frame Color") ?></label><br>
                                <input type="text" name="eyeframecolor" id="eyeframecolor" value="">
                            </div>
                            <div class="col form-group">
                                <label class="form-label fw-bold"><?php ee("Eye Color") ?></label><br>
                                <input type="text" name="eyecolor" id="eyecolor" value="">
                            </div>
                        </div>
                    <?php endif ?>
				</div>
			</div>
            <div class="card shadow-sm">
				<div class="card-header mt-2">
                    <a href="" data-bs-toggle="collapse" class="text-decoration-none" role="button" data-bs-target="#design"><h5 class="card-title fw-bold"><i class="fa fa-magic fa-lg me-3"></i> <span class="align-middle"><?php ee('Design') ?></span></h5></a>
				</div>
				<div class="card-body collapse" id="design">
                    <div class="p-3 rounded border">
                        <?php if(user()->has('qrlogo')): ?>
                        <div class="mb-3" data-toggle="buttons">
                            <label class="btn text-center border border-secondary rounded p-3 me-1" style="height:58px">
                                <input type="radio" name="selectlogo" value="none" class="d-none" checked>
                                <i data-feather="x"></i>
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="instagram" class="d-none">
                                <img src="<?php echo assets('images/instagram.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="facebook" class="d-none">
                                <img src="<?php echo assets('images/facebook.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="youtube" class="d-none">
                                <img src="<?php echo assets('images/youtube.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="twitter" class="d-none">
                                <img src="<?php echo assets('images/twitter.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="tiktok" class="d-none">
                                <img src="<?php echo assets('images/tiktok.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="linkedin" class="d-none">
                                <img src="<?php echo assets('images/linkedin.png') ?>" class="img-fluid" width="40">
                            </label>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="form-label fw-bold mb-2" for="logo"><?php ee("Custom Logo") ?></label>
                            <input type="file" class="form-control" name="logo" id="logo">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-label fw-bold d-block mb-2"><?php ee("Size") ?></label>
                            <input type="range" id="logosize" name="logosize" min="50" max="500" value="150" class="form-range">
                        </div>
                        <div class="form-group mt-4">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <label class="form-check-label fw-bold" for="punched"><?php ee('Embedded Logo') ?></label>
                                    <p class="form-text"><?php ee('Logo can now be embedded in the QR code. Please note that embedded logos can sometimes lead to unstable QR codes so please check to make sure the QR works.') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="punched" name="punched" value="1">
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block"><?php ee("Custom Logo") ?></label>
                                <a href="<?php echo route('pricing') ?>" class="mt-3 d-block border p-2 rounded-pill text-muted">
                                    <span class="btn bg-primary rounded-pill text-white"><i class="fa fa-lock mx-2"></i>  <?php ee('Upgrade') ?></span>
                                    <span class="align-middle ms-1"><?php ee('Upgrade to unlock this feature') ?></span>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div class="p-3 rounded border mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block mb-3" for="fgd"><?php ee("Matrix Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 border-secondary h-100 me-1">
                                        <svg width="30" height="15"><rect x="20" y="0" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect x="25" y="0" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect y="0" height="5" width="15" style="fill:rgb(0,0,0);"></rect><rect y="5" x="10" height="5" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="square" class="d-none" checked>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="15"><rect x="19" y="0" rx="1" ry="1" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect x="25" y="0" rx="1" ry="1" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect y="0" rx="2" ry="2" height="5" width="15" style="fill:rgb(0,0,0);"></rect><rect y="3" x="10" rx="2" ry="2" height="5" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="circle" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="15"><rect x="19" y="0" rx="5" ry="5" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect y="0" rx="5" ry="5" height="5" width="15" style="fill:rgb(0,0,0);"></rect><rect y="3" x="5" rx="5" ry="5" height="5" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="splash" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="15"><circle cx="2" cy="2" r="2" fill="black"></circle><circle cx="7" cy="2" r="2" fill="black"></circle><circle cx="12" cy="2" r="2" fill="black"></circle><circle cx="12" cy="7" r="2" fill="black"></circle><circle cx="17" cy="7" r="2" fill="black"></circle><circle cx="22" cy="7" r="2" fill="black"></circle><circle cx="22" cy="2" r="2" fill="black"></circle><circle cx="27" cy="2" r="2" fill="black"></circle><circle cx="27" cy="7" r="2" fill="black"></circle></svg>
                                        <input type="radio" name="matrix" value="dot" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="15"><rect x="0" y="0" width="3" height="3" transform="translate(3,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(8,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(13,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(13,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(18,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(23,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(23,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(28,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(28,0) rotate(45)" /></svg>
                                        <input type="radio" name="matrix" value="diamond" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"width="30" height="15" viewBox="0 0 191 97"preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,97.000000) scale(0.100000,-0.100000)"fill="#000000" stroke="none"><path d="M549 897 c-41 -27 -59 -60 -59 -108 0 -44 30 -87 134 -189 l76 -75 106 106 c91 91 106 111 111 146 13 101 -96 177 -182 125 -29 -18 -31 -18 -60 0 -40 24 -85 23 -126 -5z"/><path d="M1503 900 c-44 -26 -67 -73 -60 -123 5 -35 20 -55 111 -146 l106 -106 76 75 c104 102 134 145 134 189 0 48 -18 81 -59 108 -41 28 -86 29 -126 5 -29 -18 -31 -18 -60 0 -39 23 -82 23 -122 -2z"/><path d="M61 415 c-16 -14 -35 -42 -42 -62 -20 -61 -1 -96 109 -206 l98 -97 107 108 c102 104 107 111 107 151 0 81 -48 131 -127 131 -21 0 -48 -7 -61 -15 -19 -14 -24 -14 -51 0 -46 24 -104 19 -140 -10z"/><path d="M548 423 c-41 -26 -62 -72 -55 -123 5 -38 17 -55 109 -147 l103 -103 97 97 c59 59 102 111 109 131 16 50 4 96 -37 131 -40 36 -95 41 -145 16 -27 -14 -32 -14 -51 0 -29 20 -96 19 -130 -2z"/><path d="M1019 417 c-23 -15 -38 -37 -47 -65 -13 -38 -12 -46 7 -84 11 -24 61 -83 111 -133 l90 -90 90 90 c50 50 100 109 111 133 19 38 20 46 7 84 -23 75 -125 115 -186 72 -20 -14 -24 -14 -44 0 -33 24 -99 20 -139 -7z"/><path d="M1486 409 c-41 -35 -53 -81 -37 -131 7 -20 50 -72 109 -131 l97 -97 103 103 c92 92 104 109 109 147 11 78 -44 140 -124 140 -21 0 -48 -7 -61 -15 -19 -14 -24 -14 -51 0 -50 25 -105 20 -145 -16z"/></g></svg>
                                        <input type="radio" name="matrix" value="heart" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block mb-3"><?php ee("Eye Frame") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 border-secondary h-100 me-1">
                                        <svg width="30" height="30"><rect height="30" width="30" style="fill:rgb(255,255,255);stroke-width:8;stroke:rgb(0,0,0)"></svg>
                                        <input type="radio" name="eyeframe" value="square" class="d-none" checked>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect></svg>
                                        <input type="radio" name="eyeframe" value="rounded" class="d-none">
                                    </label>

                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><circle cx="15" cy="15" r="12" fill="white" stroke="black" stroke-width="4"></circle></svg>
                                        <input type="radio" name="eyeframe" value="circle" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="scale(4.2)"><g transform="translate(0,-14)"><path fill-rule="evenodd" d="M10 5M0 21C0 14 0 14 7 14M7 14C7 21 7 21 0 21ZM1 20C1 15 1 15 6 15M6 15C6 20 6 20 1 20M2 5z" fill="#000000"/></g></g><circle cx="15" cy="15" r="9" fill="white"></circle></svg>
                                        <input type="radio" name="eyeframe" value="eye" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="translate(-4 -8) scale(4.2)"><g transform="rotate(90 10 12)"><path fill-rule="evenodd" d="M10 5M0 21C0 14 0 14 7 14M7 14C7 21 7 21 0 21ZM1 20C1 15 1 15 6 15M6 15C6 20 6 20 1 20M2 5z" fill="#000000"/></g></g><circle cx="15" cy="15" r="9" fill="white"></circle></svg>
                                        <input type="radio" name="eyeframe" value="eyeinverted" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="20" y="20" height="10" width="10" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect><rect x="21" y="21" height="5" width="5" style="fill:rgb(255,255,255);"></rect></svg>
                                        <input type="radio" name="eyeframe" value="bubble" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block"><?php ee("Eye Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 border-secondary h-100 me-1">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="square" class="d-none" checked>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="rounded" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><circle cx="15" cy="15" r="10" fill="black"></circle></svg>
                                        <input type="radio" name="eye" value="circle" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="scale(6)"><g transform="translate(-1,-15)"><path fill-rule="evenodd" d="M10 20M2 19C2 16 2 16 5 16M5 16C5 19 5 19 2 19" fill="#000000"/></g></g></svg>
                                        <input type="radio" name="eye" value="eye" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="translate(-10 -17) scale(6)"><g transform="rotate(90 10 12)"><path fill-rule="evenodd" d="M10 20M2 19C2 16 2 16 5 16M5 16C5 19 5 19 2 19" fill="#000000"/></g></g></svg>
                                        <input type="radio" name="eye" value="eyeinverted" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><circle cx="12" cy="12" r="5" fill="black"></circle><circle cx="19" cy="12" r="5" fill="black"></circle><circle cx="12" cy="18" r="5" fill="black"></circle><circle cx="19" cy="18" r="5" fill="black"></circle></svg>
                                        <input type="radio" name="eye" value="butterfly" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect><rect x="17" y="17" height="8" width="8" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="bubble" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="30" height="30"><g transform="translate(15 -10) rotate(45)"><rect x="10" y="10" height="15" width="15" style="fill:rgb(0,0,0);"></rect></g></svg>
                                        <input type="radio" name="eye" value="diamond" class="d-none">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php if(user()->has('qrframes')): ?>
                        <div class="p-3 rounded border mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block"><?php ee("Frame Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border border-secondary rounded p-3 me-1" style="height:68px;width:68px">
                                        <input type="radio" name="frame[type]" value="none" class="d-none" checked>
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i data-feather="x"></i>
                                        </div>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(1.8) translate(2.5 0)" fill="#000000"><path d="M 1.3 28 L 22.6 28 C 23.3 28 23.9 27.4 23.9 26.7 L 24 1.4 C 24 0.7 23.33 -0.04 22.63 -0.04 L 1.4 0 C 0.7 0 0.1 0.6 0 1.3 L 0 26.6 C -0.1 27.4 0.5 28 1.3 28 Z M 1 6 C 1 5.4 1.5 5 2 5 L 22 5 C 22.6 5 23 5.5 23 6 L 23 26 C 23 26.6 22.5 27 22 27 L 2 27 C 1.4 27 1 26.5 1 26 L 1 6 Z"/></g></svg>
                                        <input type="radio" name="frame[type]" value="window" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(1.55) translate(3.5 0)" fill="#000000"><path d="M22.7,6L1.3,6C0.6,6,0,6.6,0,7.3l0,21.3C0,29.4,0.6,30,1.3,30l21.3,0c0.7,0,1.3-0.6,1.3-1.3l0-21.3 C24,6.6,23.4,6,22.7,6z M23,28c0,0.6-0.5,1-1,1L2,29c-0.6,0-1-0.5-1-1V8c0-0.6,0.5-1,1-1l20,0c0.6,0,1,0.5,1,1V28z"/><path d="M23,0H1C0.4,0,0,0.4,0,1v3c0,0.5,0.4,1,1,1h10l1,1l1-1h10c0.5,0,1-0.4,1-1V1C24,0.4,23.6,0,23,0z"/></g></svg>
                                        <input type="radio" name="frame[type]" value="popup" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><g transform="translate(3.5 0)" fill="#000000"><path d="M224.88,93.12h19.39a5,5,0,0,1,5,5v18.73H254V98.12a9.68,9.68,0,0,0-9.68-9.68H224.88Z"></path><path d="M50.73,116.85V98.12a5,5,0,0,1,5-5H73.8V88.44H55.73a9.68,9.68,0,0,0-9.68,9.68v18.73Z"></path><path d="M73.8,291.67H55.73a5,5,0,0,1-5-5V267.94H46.05v18.73a9.68,9.68,0,0,0,9.68,9.68H73.8Z"></path><path d="M249.27,267.94v18.73a5,5,0,0,1-5,5H224.88v4.68h19.39a9.68,9.68,0,0,0,9.68-9.68V267.94Z"></path><path d="M244.75,3.65H55.45A9.25,9.25,0,0,0,46.2,12.9V54.46a9.25,9.25,0,0,0,9.25,9.26H126a2.32,2.32,0,0,1,1.64.67l20.74,20.74a2.33,2.33,0,0,0,3.28,0l20.75-20.74a2.28,2.28,0,0,1,1.64-.67h70.58a9.25,9.25,0,0,0,9.25-9.26V12.9A9.18,9.18,0,0,0,244.75,3.65Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="camera" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><g transform="translate(3.5 0)" fill="#000000"><path d="M57.6,251.64H56.27V37.3H57.6Zm185.47,0h1.34V37.3h-1.34Z"></path><path d="M220.31,1.06H80.36a24.08,24.08,0,0,0-24.09,24.1V39.41H244.41V25.16A24.09,24.09,0,0,0,220.31,1.06Zm-51.94,21.1H132.3a2,2,0,0,1,0-4h36.07a2,2,0,0,1,0,4Z"></path><path d="M164.93,241.1l-14.32-12.52L135.9,241.1H56.27v33.3a24.07,24.07,0,0,0,24.09,24.09h140a24.08,24.08,0,0,0,24.1-24.09V241.1Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="phone" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><path d="M 74.713 178.459 C 74.83 176.468 75.016 174.408 75.193 172.417 C 75.369 170.425 75.663 168.424 76.026 166.49 C 76.388 164.557 76.8 162.623 77.27 160.738 C 77.741 158.982 78.378 157.273 79.171 155.633 C 79.23 155.459 79.298 155.218 79.357 154.986 C 79.741 153.118 78.509 151.3 76.613 150.935 L 76.437 150.877 C 76.265 150.832 76.086 150.812 75.908 150.819 C 75.722 150.819 75.604 150.761 75.428 150.761 C 75.252 150.761 74.83 150.703 74.536 150.703 C 73.939 150.703 73.351 150.761 72.753 150.761 C 71.567 150.877 70.431 151.003 69.304 151.177 C 67.058 151.521 64.834 151.989 62.641 152.578 C 60.499 153.201 58.395 153.947 56.341 154.812 C 55.361 155.218 54.313 155.778 53.304 156.165 C 52.294 156.552 51.344 157.219 50.364 157.683 C 49.869 157.968 49.872 158.675 50.37 158.956 C 50.529 159.045 50.715 159.074 50.893 159.037 L 50.962 159.037 C 52.03 158.805 53.039 158.505 54.048 158.273 C 55.057 158.041 56.135 157.809 57.144 157.683 C 59.202 157.302 61.285 157.063 63.376 156.968 C 64.689 156.91 66.051 156.91 67.364 156.91 C 64.662 160.025 62.289 163.404 60.28 166.993 C 57.655 171.725 55.506 176.698 53.862 181.843 C 50.608 192.017 48.956 202.623 48.963 213.292 C 48.92 223.887 50.573 234.423 53.862 244.509 C 57.21 254.531 62.369 263.873 69.088 272.082 C 69.39 272.457 69.934 272.537 70.333 272.265 C 70.741 271.979 70.821 271.414 70.509 271.028 C 64.329 262.805 59.717 253.541 56.9 243.688 C 51.512 223.976 52.405 203.105 59.457 183.912 C 61.201 179.206 63.393 174.675 66.002 170.377 C 67.626 167.709 69.499 165.198 71.597 162.875 C 71.597 164.044 71.597 165.156 71.656 166.336 C 71.773 168.443 71.891 170.503 72.126 172.552 C 72.361 174.602 72.606 176.661 72.959 178.71 C 73.026 179.156 73.396 179.497 73.85 179.532 C 74.317 179.36 74.649 178.947 74.713 178.459 Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="arrow" class="d-none">
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><path d="M253.83.69H46.09A11.28,11.28,0,0,0,34.77,12V219.83a11.33,11.33,0,0,0,11.32,11.31H253.91a11.33,11.33,0,0,0,11.32-11.31V12A11.41,11.41,0,0,0,253.83.69Zm2.64,215.59a6.1,6.1,0,0,1-6.11,6.11H49.55a6.1,6.1,0,0,1-6.11-6.11V15.47a6.1,6.1,0,0,1,6.11-6.11H250.36a6.09,6.09,0,0,1,6.11,6.11Z"></path><path id="IconCircleOutline" d="M64.42,246.09A23.53,23.53,0,1,0,88,269.62a23.47,23.47,0,0,0-23.53-23.53Z" fill-opacity="0"></path><path id="PhoneIcon" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z"></path><path id="PhoneIconBlack" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z" fill-opacity="0"></path><path d="M235.5,240H64.42a29.68,29.68,0,0,0,0,59.36h171A29.68,29.68,0,0,0,235.5,240ZM64.42,293.15A23.53,23.53,0,1,1,88,269.62,23.47,23.47,0,0,1,64.42,293.15Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="labeled" class="d-none">
                                    </label>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold d-block mb-2"><?php ee("Text") ?></label>
                                            <input type="text" value="" name="frame[text]" placeholder="e.g. Scan me" class="form-control p-2">
                                            <div class="form-text"><?php ee('Limit of {x} characters', null, ['x' => 20]) ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold d-block mb-2"><?php ee("Font") ?></label>
                                            <select name="frame[font]" class="form-select p-2">
                                                <?php foreach(['Arial', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'] as $font): ?>
                                                    <option value="<?php echo $font ?>" style="font-family: '<?php echo str_replace('_', ' ', $font) ?>'"><?php echo str_replace('_', ' ', $font) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee("Frame Color") ?></label><br>
                                        <input type="text" name="frame[color]" id="framecolor" value="#000000">
                                    </div>
                                    <div class="col form-group">
                                        <label class="form-label fw-bold"><?php ee("Text Color") ?></label><br>
                                        <input type="text" name="frame[textcolor]" id="frametextcolor" value="#ffffff">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="p-3 rounded border mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold d-block"><?php ee("Frame Style") ?></label>
                                    <a href="<?php echo route('pricing') ?>" class="mt-3 d-block border p-2 rounded-pill text-muted">
                                        <span class="btn bg-primary rounded-pill text-white"><i class="fa fa-lock mx-2"></i>  <?php ee('Upgrade') ?></span>
                                        <span class="align-middle ms-1"><?php ee('Upgrade to unlock this feature') ?></span>
                                    </a>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endif ?>

                    <div class="p-3 rounded border mt-3">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold d-block mb-3"><?php ee("Margin") ?></label>
                            <input type="number" value="" name="margin" placeholder="e.g. 10" class="form-control p-2">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold d-block mb-2"><?php ee("Error Correction") ?></label>
                            <div class="form-text mb-3"><?php ee('Error correction allows better readability when code is damaged or dirty but increase QR data') ?></div>
                            <select name="error" class="form-select p-2">
                                <option value="l">L (7%)</option>
                                <option value="m" selected>M (15%)</option>
                                <option value="q">Q (25%)</option>
                                <option value="h">H (30%)</option>
                            </select>
                        </div>
                    </div>
				</div>
			</div>
        </div>
        <div class="col-md-5">
            <div id="qr-preview">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><?php ee('QR Code') ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="return-ajax">
                            <img src="<?php echo \Helpers\QR::factory('Sample QR', 400, 0)->format('svg')->create('uri') ?>" class="img-responsive w-100 mw-50">
                        </div>
                    </div>
                </div>
                <div class="card card-body shadow-sm">
                    <div class="d-flex">
                        <button type="button" data-trigger="preview" data-url="<?php echo route("qr.preview") ?>" class="flex-fill btn btn-primary me-1"><?php ee('Preview') ?></button>
                        <button type="submit" class="flex-fill btn btn-success ms-1" data-load><?php ee('Generate QR') ?></button>
                    </div>
                </div>
                <div class="card card-body shadow-sm">
                    <p><?php ee("You will be able to download the QR code in PDF or SVG after it has been generated.") ?></p>
                    <p><?php ee("If you are using a fancy design, your QR code might not be readible. If that is the case, you can increase Error Correction to ensure optimal readability. It is recommended to test the QR code before saving it.") ?></p>
                </div>
            </div>
        </div>
    </div>
</form>