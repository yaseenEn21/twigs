<form method="post" action="<?php echo route('links.update', [$url->id]) ?>" enctype="multipart/form-data">
    <div class="d-flex mb-5">
        <div>
            <h1 class="h3 fw-bold"><?php ee('Update Link') ?></h1>
        </div>
        <div class="ms-auto">
            <button type="submit" class="btn btn-primary"><?php ee('Update Link') ?></button>
            <a href="<?php echo route('stats', [$url->id]) ?>" class="btn btn-success"><i data-feather="bar-chart-2"></i> <span class="d-md-inline d-none"><?php ee('Statistics') ?></span></a>
            <?php if(\Core\Auth::user()->has('export')): ?>
                <a class="btn btn-success" href="<?php echo route('links.stats.export', [$url->id]) ?>"><i data-feather="download"></i> <span class="d-md-inline d-none"><?php ee('Export Statistics') ?></span></a>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="url" class="form-label fw-bold"><?php ee('URL') ?></label>
                        <div class="input-group">
                            <div class="input-group-text  <?php echo \Core\Auth::user()->pro() ? 'bg-white' : '' ?>"><img src="<?php echo route('link.ico', $url->id) ?>" width="16"></div>
                            <input type="text" class="form-control p-2 border-start-0 ps-0" id="url" name="url" value="<?php echo $url->url ?>" autocomplete="off" <?php echo !user()->pro() ? 'readonly' : '' ?>>
                        </div>
                    </div>
                    <div id="metatags" class="mt-4 border p-3 rounded-3">
                        <h4><?php echo e("Meta Tags")?></h4>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="metaimage" class="form-label fw-bold"><?php ee('Custom Banner') ?></label>
                                    <input type="file" class="form-control p-2" name="metaimage" id="metaimage" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="metatitle" class="form-label fw-bold"><?php ee('Meta Title') ?></label>
                                    <input type="text" class="form-control p-2" name="metatitle" id="metatitle" value="<?php echo $url->meta_title ?>" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="metadescription" class="form-label fw-bold"><?php ee('Meta Description') ?></label>
                                    <input type="text" class="form-control p-2" name="metadescription" id="metadescription" value="<?php echo $url->meta_description ?>" placeholder="<?php echo e("Enter your custom meta description")?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(config("geotarget") && \Core\Auth::user()->has("geo") !== false):?>
                        <div class="mt-4 border p-3 rounded-3" id="geo">                            
                            <div class="d-flex">
                                <h4><?php echo e("Geo Targeting")?></h4>
                                <div class="ms-auto">
                                    <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="geo"><?php echo e("+ Add")?></a>
                                </div>
                            </div>
                            <p class="form-text mt-3"><?php echo e('If you have different pages for different countries then it is possible to redirect users to that page using the same URL. Simply choose the country and enter the URL.')?></p>
                            <?php foreach($locations as $name => $link):?>
                                <?php $name = explode('|', $name) ?>
                                <div class="row">
                                    <div class="col col-sm-6 mt-3">
                                        <div class="input-group input-select">
                                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                            <select name="location[]" class="form-control border-start-0 ps-0" data-trigger="getStates" data-toggle="select">
                                                <?php echo \Core\Helper::Country(uppercountryname($name[0]), true) ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-sm-6 mt-3">
                                        <div class="input-group input-select">
                                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                            <select name="state[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                                <option value="0"><?php ee('All States') ?></option>
                                                <?php foreach(\Helpers\App::states(uppercountryname($name[0])) as $state): ?>
                                                    <option value="<?php echo strtolower($state->name) ?>" <?php echo isset($name[1]) && strtolower($state->name) == strtolower($name[1]) ? 'selected' : '' ?>><?php echo $state->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-sm-12 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                            <input type="text" name="target[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="<?php echo $link ?>">
                                        </div>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore"><?php ee('Delete') ?></a></p>
                            <?php endforeach ?>
                            <div class="row d-none" data-toggle="addable" data-label="geo" data-states="<?php echo route('server.states') ?>">
                                <div class="col col-sm-6 mt-3">
                                    <div class="input-group input-select">
                                        <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                        <select name="location[]" class="form-control border-start-0 ps-0" data-trigger="getStates" data-toggle="select">
                                            <?php echo \Core\Helper::Country('United States', true) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-sm-6 mt-3">
                                    <div class="input-group input-select">
                                        <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                        <select name="state[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                            <option value="0"><?php ee('All States') ?></option>
                                            <?php foreach(\Helpers\App::states('United States') as $state): ?>
                                                <option value="<?php echo strtolower($state->name) ?>"><?php echo $state->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-sm-12 mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                        <input type="text" name="target[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if(\Core\Auth::user()->has("deeplink") !== false && config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
                        <div class="mt-4 border p-3 rounded-3" id="deeplink">
                            <div class="form-group d-flex align-items-center">
                                <div>
                                    <label for="deeplink[enabled]" class="form-label h4"><?php ee('Deep Linking') ?></label>
                                    <p class="form-text mb-0"><?php ee('Enable this feature to force apps to open when visiting on mobile or open app store if app is not installed.') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="deeplink[enabled]" name="deeplink[enabled]" value="1" data-toggle="togglefield" data-toggle-for="deelinkapple,deelinkgoogle" <?php echo isset($url->deeplink['enabled']) && $url->deeplink['enabled'] ? 'checked':'' ?> data-server="<?php echo route('server.deeplink') ?>">
                                </div>
                            </div>
                            <div class="form-group my-3 <?php echo !isset($url->deeplink['enabled']) || !$url->deeplink['enabled'] ? 'd-none':'' ?>">
                                <p class="mb-3 border border-primary border-2 text-primary rounded-3 p-2"><?php ee('To use deep links, you will need to define a main URL that will be used for all other devices, an app specific URL for iPhone/iPad and/or Android and the associated app store URL.') ?></p>
                                <label class="form-label fw-bold"><?php ee('Link to App Store') ?></label>
                                <input type="text" class="form-control p-2" id="deelinkapple" name="deeplink[apple]" placeholder="https://" value="<?php echo $url->deeplink['apple'] ?? '' ?>">
                            </div>
                            <div class="form-group <?php echo !isset($url->deeplink['enabled']) || !$url->deeplink['enabled'] ? 'd-none':'' ?>">
                                <label class="form-label fw-bold"><?php ee('Link to Google Play') ?></label>
                                <input type="text" class="form-control p-2" id="deelinkgoogle" name="deeplink[google]" placeholder="https://" value="<?php echo $url->deeplink['google'] ?? '' ?>">
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if(config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>                        
                        <div class="mt-4 border p-3 rounded-3" id="device">
                            <div class="d-flex">
                                <h4><?php echo e("Device Targeting")?></h4>
                                <div class="ms-auto">
                                    <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="device"><?php echo e("+ Add")?></a>
                                </div>
                            </div>
                            <p class="form-text mt-3">
                                <?php echo e('If you have different pages for different devices (such as mobile, tablet etc) then it is possible to redirect users to that page using the same short URL. Simply choose the device and enter the URL.')?>
                            </p>
                            <?php foreach($url->devices as $name => $link):?>
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group input-select">
                                            <span class="input-group-text bg-white"><i data-feather="smartphone"></i></span>
                                            <select name="device[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                                <?php echo \Core\Helper::devices($name) ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                            <input type="text" name="dtarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="<?php echo $link ?>">
                                        </div>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore"><?php ee('Delete') ?></a></p>
                            <?php endforeach ?>
                            <div class="row d-none" data-toggle="addable" data-label="device">
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group input-select">
                                            <span class="input-group-text bg-white"><i data-feather="smartphone"></i></span>
                                            <select name="device[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                                <?php echo \Core\Helper::devices() ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                            <input type="text" name="dtarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    <?php endif ?>
                    <?php if( \Core\Auth::user()->has("language") !== false):?>                        
                        <div class="mt-4 border p-3 rounded-3" id="language">
                            <div class="d-flex">
                                <h4><?php echo e("Language Targeting")?></h4>
                                <div class="ms-auto">
                                    <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="language"><?php echo e("+ Add")?></a>
                                </div>
                            </div>
                            <p class="form-text mt-3">
                                <?php echo e('If you have different pages for different languages then it is possible to redirect users to that page using the same short URL. Simply choose the language and enter the URL.')?>
                            </p>
                            <?php foreach($url->languages as $name => $link):?>
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group input-select">
                                            <span class="input-group-text bg-white"><i data-feather="type"></i></span>
                                            <select name="language[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                                <?php echo \Helpers\App::languagelist($name) ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                            <input type="text" name="ltarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="<?php echo $link ?>">
                                        </div>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore"><?php ee('Delete') ?></a></p>
                            <?php endforeach ?>
                            <div class="row d-none" data-toggle="addable" data-label="language">
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-select">
                                        <span class="input-group-text bg-white"><i data-feather="type"></i></span>
                                        <select name="language[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                            <?php echo \Helpers\App::languagelist('en') ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                                        <input type="text" name="ltarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if(user()->has('expiration')): ?>                        
                        <div class="mt-4 border p-3 rounded-3">
                            <div class="d-flex">
                                <h4><?php echo e("Expiration")?></h4>
                            </div>
                            <p class="form-text">
                                <?php echo e("Links can be expired based on the amount of clicks or a specific date. You can also set a url to redirect to when the link expires.")?>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="expiry" class="form-label fw-bold"><?php ee('Link Expiration') ?></label>
                                        <div class="input-group">
                                            <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                                            <input type="text" class="form-control p-2 border-start-0 ps-0 p-2" data-toggle="datepicker" name="expiry" id="expiry" placeholder="<?php echo e("MM/DD/YYYY")?>" autocomplete="off" value="<?php echo $url->expiry ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php if (\Core\Auth::user()->has("clicklimit") !== false): ?>
                                    <div class="form-group mb-3">
                                        <label for="clicklimit" class="form-label fw-bold"><?php ee('Expiration by Clicks') ?></label>
                                        <div class="input-group">
                                            <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                                            <input type="text" class="form-control p-2 border-start-0 ps-0 p-2" name="clicklimit" id="clicklimit" placeholder="e.g. 100" autocomplete="off" value="<?php echo $url->clicklimit ?>">
                                        </div>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="expiry" class="form-label fw-bold"><?php ee('Expiration Redirect') ?></label>
                                <p class="form-text"><?php ee('Set a link to redirect traffic to when the short link expires.') ?></p>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                    <input type="text" name="expirationredirect" class="form-control p-2 border-start-0 ps-0" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="<?php echo $url->expirationredirect ?>">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if( \Core\Auth::user()->has("abtesting") !== false):?>                        
                        <div class="mt-4 border p-3 rounded-3" id="abtesting">
                            <div class="d-flex">
                                <h4><?php echo e("A/B Testing and Rotator")?></h4>
                                <div class="ms-auto">
                                    <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="abtesting"><?php echo e("+ Add")?></a>
                                </div>
                            </div>
                            <p class="form-text mt-3">
                                <?php echo e('You can rotate multiple links using short link using the feature. If you do not assign a percentage or the percentage is 100% for all links then the traffic will equally distributed. Please note that default link will be added to the list as well and rotator will not work if you assign another targeting condition that matches.')?>
                            </p>
                            <?php foreach($url->rotators as $rotator):?>
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                            <input type="text" name="abtesting[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>" value="<?php echo $rotator['link'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i data-feather="percent"></i></span>
                                            <input type="text" name="abtestingpercent[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type percentage e.g. 100")?>"value="<?php echo $rotator['percent'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore"><?php ee('Delete') ?></a></p>
                            <?php endforeach ?>
                            <div class="row d-none" data-toggle="addable" data-label="abtesting">
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                                        <input type="text" name="abtesting[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="percent"></i></span>
                                        <input type="text" name="abtestingpercent[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type percentage e.g. 100")?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if(\Core\Auth::user()->has("pixels") !== false):?>
                    <div id="pixels" class="mt-4 border p-3 rounded-3">                        
                        <h4><?php echo e("Targeting Pixels")?></h4>
                        <p class="form-text mt-3"><?php echo e('Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings.')?></p>
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="filter"></i></span>
                            <select name="pixels[]" data-placeholder="Your Pixels" multiple data-toggle="select">
                                <?php foreach(\Core\Auth::user()->pixels() as $type => $pixels): ?>
                                    <optgroup label="<?php echo ucwords($type) ?>">
                                    <?php foreach($pixels as $pixel): ?>
                                        <option value="<?php echo $pixel->type ?>-<?php echo $pixel->id ?>" <?php echo in_array($pixel->type.'-'.$pixel->id, $url->pixels) ? 'selected': '' ?>><?php echo $pixel->name ?></option>
                                    <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if (\Core\Auth::user()->has("parameters") !== false): ?>
                    <div class="mt-4 border p-3 rounded-3" id="parameters">                        
                        <div class="d-flex">
                            <h4><?php echo e("Parameter Builder")?></h4>
                            <div class="ms-auto">
                                <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="parameters"><?php echo e("+ Add")?></a>
                            </div>
                        </div>
                        <p class="form-text mt-3">
                            <?php echo e("You can add custom parameters like UTM to the link above using this tool. Choose the parameter name and then assign a value. These will be added during redirection.")?>
                        </p>
                        <?php foreach($url->parameters as $name => $value):?>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i data-feather="list"></i></span>
                                    <input type="text" name="paramname[]" class="form-control p-2 border-start-0 ps-0" data-trigger="autofillparam" value="<?php echo $name ?>" placeholder="<?php echo e("Parameter name")?>">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i data-feather="edit"></i></span>
                                    <input type="text" name="paramvalue[]" class="form-control p-2 border-start-0 ps-0" value="<?php echo $value ?>" placeholder="<?php echo e("Parameter value")?>">
                                </div>
                            </div>
                        </div>
                        <p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore"><?php ee('Delete') ?></a></p>
                        <?php endforeach ?>
                        <div class="row d-none" data-toggle="addable" data-label="parameters">
                            <div class="col-sm-6 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i data-feather="list"></i></span>
                                    <input type="text" name="paramname[]" class="form-control p-2 border-start-0 ps-0" data-trigger="autofillparam" placeholder="<?php echo e("Parameter name")?>">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i data-feather="edit"></i></span>
                                    <input type="text" name="paramvalue[]" class="form-control p-2 border-start-0 ps-0" placeholder="<?php echo e("Parameter value")?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <button type="submit" class="btn btn-primary mt-4"><?php ee('Update Link') ?></button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php if($url->meta_image): ?>
                <div class="card shadow-sm">
                    <img class="card-img-top" src="<?php echo uploads($url->meta_image, 'images') ?>" alt="<?php echo $url->meta_title ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-2"><?php echo $url->meta_title ?></h5>
                        <p class="card-text text-muted"><?php echo $url->meta_description ?></p>
                    </div>
                </div>
            <?php endif ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>/qr" alt="<?php echo $url->meta_title ?>" width="60">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="mb-3 d-block"><i class="fa fa-link me-2"></i> <small data-href="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></small>
                            <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><small><?php echo e("Copy")?></small></a></span>

                            <i class="fa fa-qrcode me-2"></i> <small data-href="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>/qr"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>/qr</small>
                            <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>/qr"><small><?php echo e("Copy")?></small></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if($domains = \Helpers\App::domains()): ?>
                        <div class="form-group mb-3 rounded input-select">
                            <label for="domain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                            <select name="domain" id="domain" class="form-select border-start-0 ps-0" data-toggle="select">
                                <?php foreach($domains as $domain): ?>
                                    <option value="<?php echo $domain ?>" <?php echo $url->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    <?php endif ?>
                    <?php if($redirects = \Helpers\App::redirects()): ?>
                        <div class="form-group mb-3 rounded input-select">
                            <label for="type" class="form-label fw-bold"><?php ee('Redirect') ?></label>
                            <select name="type" id="type" class="form-select border-start-0 ps-0" data-toggle="select">
                                <?php foreach($redirects as $name => $redirect): ?>
                                    <optgroup label="<?php echo $name ?>">
                                    <?php foreach($redirect as $id => $name): ?>
                                        <option value="<?php echo $id ?>" <?php echo $url->type == $id ? 'selected' : '' ?>><?php echo $name ?></option>
                                    <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        </div>
                    <?php endif ?>
                    <?php if(!$url->custom):?>
                    <div class="form-group mb-3">
                        <label for="alias" class="form-label fw-bold"><?php ee('Alias') ?></label>
                        <div class="input-group input-select">
                            <div class="input-group-text"><i data-feather="globe"></i></div>
                            <input type="text" class="form-control p-2 border-start-0 ps-0" id="alias" value="<?php echo $url->alias ?>" disabled autocomplete="off">
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if (\Core\Auth::user()->has("alias") !== false): ?>
                    <div class="form-group mb-3">
                        <label for="custom" class="form-label fw-bold"><?php ee('Custom') ?></label>
                        <div class="input-group">
                            <div class="input-group-text bg-white"><i data-feather="globe"></i></div>
                            <input type="text" class="form-control p-2 border-start-0 ps-0" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off" value="<?php echo $url->custom ?>">
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="form-group mb-3">
                        <label for="pass" class="form-label fw-bold"><?php ee('Password Protection') ?></label>
                        <div class="input-group">
                            <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                            <input type="text" class="form-control p-2 border-start-0 ps-0" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off" value="<?php echo $url->pass ?>">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expiry" class="form-label fw-bold"><?php echo e("Description")?></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="tag"></i></span>
                            <input type="text" class="form-control p-2 border-start-0 ps-0" name="description" id="description" placeholder="<?php echo e("Type your description here")?>" autocomplete="off" value="<?php echo $url->description ?>">
                        </div>
                    </div>
                    <div class="form-group mb-3 rounded input-select">
                        <label for="type" class="form-label fw-bold"><?php ee('Campaign') ?></label>
                        <select name="bundle" id="bundle" class="form-select border-start-0 ps-0" data-toggle="select">
                            <option value="0"><?php echo e('None') ?></option>
                            <?php foreach(\Core\DB::bundle()->where('userid', user()->rID())->find() as $campaign): ?>
                                <option value="<?php echo $campaign->id ?>" <?php echo $url->bundle == $campaign->id ? 'selected' : '' ?>><?php echo $campaign->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <label for="channels" class="form-label d-block mb-2 fw-bold"><?php ee('Channels') ?></label>
                    <div class="form-group rounded input-select">
                        <select name="channels[]" id="channels" class="form-control" multiple data-toggle="select">
                            <?php foreach(\Core\DB::channels()->where('userid', user()->rID())->findArray() as $channel): ?>
                                <option value="<?php echo $channel['id'] ?>" <?php echo in_array($channel['id'], $channels) ? 'selected' : '' ?>><?php echo $channel['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>