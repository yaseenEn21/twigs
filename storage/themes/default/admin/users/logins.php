<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
	</ol>
</nav>
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php ee('Login Logs') ?></h1>
    <div class="ms-auto">
		<a href="<?php echo route('admin.users.loginsclear', [\Core\Helper::nonce('login.clear')]) ?>" class="btn btn-primary"><?php ee('Clear Logs') ?></a>
	</div>
</div>
<div class="card flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th><?php ee('Email') ?></th>
					<th><?php ee('Logged Details') ?></th>
					<th><?php ee('Date') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($events as $event): ?>
					<tr>
						<td>							
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $event->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo ($event->user->admin)?"<strong>{$event->user->email}</strong>":$event->user->email ?>
                                </div>
                            </div>
                        </td>
                        <td width="50%">
                            <?php if($event->data->country): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::flag($event->data->country) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->country) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->city ? ucfirst($event->data->city).',': e('Somewhere from') ?> <?php echo ucfirst($event->data->country) ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->os): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::os($event->data->os) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->os) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->os ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->browser): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::browser($event->data->browser) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->browser) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->browser ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->ip): ?>
                                <span class="text-start d-inline-block">
                                    <span data-feather="globe"></span>
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->ip ?></span>
                                </span>
                            <?php endif ?>
                            <?php if(isset($event->data->social) && $event->data->social): ?>
                                <span class="text-start d-inline-block">
                                    <span data-feather="share-2"></span>
                                    <span class="mr-3 align-middle"><?php echo ucwords($event->data->social) ?></span>
                                </span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php echo $event->created_at ?>
                        </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<div class="mt-4 d-block">
	<?php echo pagination('pagination justify-content-center border rounded p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div>  