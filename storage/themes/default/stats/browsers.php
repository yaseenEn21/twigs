<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>

<div class="card card-body shadow-sm mb-4">
    <div class="align-items-center">
        <?php view('partials.stats_nav', ['url' => $url]) ?>
    </div>
</div>
<div class="d-flex mb-4 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('Browsers') ?></h3>
    <div class="ms-auto ml-auto card mb-0 shadow-sm p-2">
        <input type="text" name="customreport" data-action="customreport" class="form-control border-0" placeholder="<?php echo e("Choose a date range to update stats") ?>">
    </div> 
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-0">            
            <div class="card-body px-4">
                <canvas data-trigger="dynamic-pie" data-url="<?php echo route('data.browsers', [$url->id]) ?>" data-type="browsers" style="min-height:200px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="p-3">
                <h5 class="card-title mb-0 fw-bold"><?php ee('Top Browsers') ?></h5>
            </div>
            <div class="card-body px-3">
                <ul id="top-browsers" class="list-unstyled d-block"></ul>
            </div>
        </div>
    </div>
</div>