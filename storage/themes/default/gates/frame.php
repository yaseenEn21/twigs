<div id="frame" class="bg-dark p-3">
    <div class="row">
        <div class="col-sm-4">
            <a class="navbar-brand" href="<?php echo route('home') ?>">
                <?php if(config('logo')): ?>
                    <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                <?php else: ?>
                    <h1 class="h5 mt-2 text-white"><?php echo config('title') ?></h1>
                <?php endif ?>
            </a>    
        </div>
        <div class="col-sm-4 hidden-xs">
            <?php \Helpers\App::ads('frame') ?>
        </div>
        <div class="col-sm-4">
            <div class="d-flex mt-1">
                <div class="btn-group ml-auto">
                    <a href="<?php echo $url->url ?>" class="btn btn-primary btn-xs"><?php echo e("Close") ?></a>
                </div>                
            </div>
        </div>         
    </div>
</div>
<iframe id="site" src="<?php echo $url->url ?>" frameborder="0" loading="lazy" style="border: 0; width: 100%; height: 100%;position: absolute;top: 90px;z-index: 1;" scrolling="yes"></iframe>