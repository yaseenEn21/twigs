<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Verifications') ?></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Verifications') ?></h1>
<?php if(!config('verification')): ?>
    <div class="alert alert-danger p-3 rounded"><?php ee('Verification system is disabled. You can enable it in User Settings.') ?></div>
<?php endif ?>
<div class="card flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($verifications as $verification): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $verification->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo ($verification->user->admin)?"<strong>{$verification->user->email}</strong>":$verification->user->email ?> <?php echo ($verification->user->trial)?"(".e('Free Trial').")":"" ?>
                                    <?php echo ($verification->user->teams())?"<strong class=\"badge bg-primary\">".e("Team")."</strong>":'' ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $verification->created_at ?></td>                
                        <td>
                            <?php if($verification->status == '1'): ?>
                                <span class="border border-1 border-danger rounded-3 p-2 text-danger"><?php ee('Rejected') ?></span><br>
                            <?php elseif($verification->status == '2') :?>
                                <span class="border border-1 border-success rounded-3 p-2 text-success"><?php ee('Approved') ?></span><br>
                            <?php else: ?>
                                <span class="border border-1 border-primary rounded-3 p-2 text-primary"><?php ee('Pending') ?></span><br>
                            <?php endif ?>                            
                        </td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.verifications.view', [$verification->id]) ?>"><i data-feather="file"></i> <?php ee('View Document') ?></a></li>
                                <?php if($verification->status != '2') :?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.users.verify', [$verification->user->id, \Core\Helper::nonce('verify-'.$verification->user->id)]) ?>"><i data-feather="check-circle" class="text-primary"></i> <?php ee('Verify User') ?></a></li>                      
                                <?php endif ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php echo pagination('pagination') ?>
</div>