<section id="blog" class="bg-primary">
	<div class="container">
		<div class="py-10 text-center">
            <h2 class="display-6 fw-bold">
                <?php ee('Blog') ?>
            </h2>
        </div>
        <?php view('blog.menu', compact('menu', 'q')) ?>
        <div class="py-5">
            <div class="row">                
                <?php if(themeSettings::config('blog') == 'grid'): ?>
                    <div class="col-md-12 mb-5">
                        <h3 class="mb-5"><?php ee('Results for "{q}"', null, ['q' => $q]) ?></h3>
                        <?php if($posts): ?>
                            <div class="row">
                            <?php foreach($posts as $post): ?>
                                <div class="col-sm-4">
                                    <?php view('blog.partial', compact('post', 'categories')); ?>
                                </div>
                            <?php endforeach ?>
                            </div>
                        <?php else: ?>
                            <?php ee('No results') ?>
                        <?php endif ?>                        
                        <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
                    </div>
                <?php else: ?>
                    <div class="col-md-8 mb-5">
                        <h3 class="mb-5"><?php ee('Results for "{q}"', null, ['q' => $q]) ?></h3>
                        <?php if($posts): ?>
                            <?php foreach($posts as $post): ?>
                                <?php view('blog.partial', compact('post', 'categories')); ?>
                            <?php endforeach ?>
                            <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
                        <?php else: ?>
                            <?php ee('No results') ?>
                        <?php endif ?>
                    </div>
                    <div class="col-md-4">
                        <?php \Helpers\App::ads('blogsidebar') ?>
                        <h5 class="fw-bolder mb-3"><?php ee('Popular Posts') ?></h5>
                        <?php foreach($popular as $post): ?>
                            <a href="<?php echo route('blog.post', [$post->slug]) ?>" class="mb-2 d-block" title="<?php echo $post->title ?>"><?php echo $post->title ?></a>
                        <?php endforeach ?>
                        <?php plug('blogsidebar') ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>