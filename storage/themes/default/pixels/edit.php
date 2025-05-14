<div class="d-flex mb-5">
    <div>
        <h1 class="h3 fw-bold"><img src="<?php echo assets('images/'.str_replace(['pixel','fb'], ['', 'facebook'], $pixel->type).'.svg') ?>" width="45" class="me-2"> <?php echo $pixel->name ?> (<?php echo \Helpers\App::pixelName($pixel->type) ?>)</h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('links', ['pixel' => "{$pixel->type}-{$pixel->id}"]) ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('View Links') ?></a>
    </div>    
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('pixel.update', [$pixel->id]) ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="pixel" class="form-label"><?php ee('Pixel Name') ?></label>
                                <input type="text" class="form-control p-2" name="pixel" id="pixel" value="<?php echo $pixel->name ?>" placeholder="<?php echo e("Shopify Campaign") ?>">
                            </div>	
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="tag" class="form-label"><?php echo e("Pixel Tag") ?></label>
                                <input type="text" name="tag" class="form-control p-2" value="<?php echo $pixel->tag ?>" placeholder="e.g. <?php echo e("Numerical or alphanumerical values only") ?>" /> 
                            </div>	
                        </div>                
                    </div>                    
                    <button type="submit" class="btn btn-primary"><?php ee('Update Pixel') ?></button>
                </form>
            </div>
        </div>               
    </div>    
</div>