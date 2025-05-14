<section class="bg-primary py-10 vh-100">
    <div class="container align-items-center">
        <div class="card border-0 shadow-sm">
            <img src="<?php echo uploads($splash->data->banner) ?>" class="rounded w-100">
            <div class="card-body">
                <div class="d-flex flex-sm-row flex-column align-items-center">
                    <div>
                        <img src="<?php echo uploads($splash->data->avatar) ?>" height="150" class="rounded">
                    </div>
                    <div class="ms-3 ml-3">
                        <strong><?php echo $splash->data->title ?></strong>
                        <p class="mt-2 pe-5"><?php echo $splash->data->message ?></p>
                        <p><a href="<?php echo $splash->data->product ?>" rel="nofollow" target="_blank" class="btn btn-primary btn-sm"><?php ee('View site') ?></a></p>
                    </div>
                    <div class="ms-auto ml-auto">
                        <p id="counter" class="text-center"><span class="fs-2">0</span><br><?php ee('Seconds') ?></p>
                    </div>
                </div>
            </div>
        </div>        
        <?php if(!$user->has('poweredby')): ?>
            <?php echo e('Powered by') ?> <a href="<?php echo config('url') ?>" class="font-weight-bold"><?php echo config('title') ?></a>      
        <?php endif ?>
    </div>
</section>