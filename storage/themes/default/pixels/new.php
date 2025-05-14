<h1 class="h3 mb-5 fw-bold"><?php ee('Add Pixel') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('pixel.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
                    <?php echo csrf() ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="type" class="form-label"><?php echo e("Pixel Provider") ?></label>
                                <select name="type" id="type" class="form-control" data-toggle="select">
                                    <?php foreach($providers as $key => $provider): ?>
                                        <option value="<?php echo $key ?>"><?php echo $provider['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="pixel" class="form-label"><?php ee('Pixel Name') ?></label>
                                <input type="text" class="form-control p-2" name="pixel" id="pixel" value="" placeholder="<?php echo e("Shopify Campaign") ?>">
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="tag" class="form-label"><?php echo e("Pixel Tag") ?></label>
                                <input type="text" value="" name="tag" class="form-control p-2" placeholder="e.g. <?php echo e("Numerical or alphanumerical values only") ?>" /> 
                            </div>	
                        </div>                
                    </div>                    
                    <button type="submit" class="btn btn-primary"> <?php ee('Add Pixel') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What are tracking pixels?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs.') ?></p>
                <a href="<?php echo route('faq') ?>#pixels" class="btn btn-primary btn-sm"><?php ee("More info") ?></a>             
            </div>
        </div>
    </div>
</div>