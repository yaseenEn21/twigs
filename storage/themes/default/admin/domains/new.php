<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.domains') ?>"><?php ee('Domains') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('New Domain') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.domains.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
                    <?php echo csrf() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="domain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                                <input type="text" class="form-control p-2" name="domain" id="domain" value="<?php echo old('domain') ?>" placeholder="https://domain.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4 input-select rounded">
                                <label for="status" class="form-label fw-bold"><?php ee('Status') ?></label>
                                <select name="status" id="status" class="form-control p-2" data-toggle="select">
                                    <option value="0"><?php ee('Disabled') ?></option>
                                    <option value="1" selected><?php ee('Active') ?></option>
                                    <option value="2"><?php ee('Pending DNS') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4 input-select rounded">
                        <label for="user" class="form-label fw-bold"><?php ee('Assign to User') ?></label>
                        <select name="user" id="user" class="form-control" data-trigger="userlist" data-route="<?php echo route('admin.users.list') ?>">                        
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="root" class="form-label fw-bold"><?php ee('Domain Root') ?></label>
                                <input type="text" class="form-control p-2" name="root" id="rootdomain" value="<?php echo old('root') ?>" placeholder="https://mycompany.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="root404" class="form-label fw-bold"><?php ee('Domain 404') ?></label>
                                <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo old('root404') ?>" placeholder="https://mycompany.com/404">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php ee('Add Domain') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Assigning Domains') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('Before assigning domains, make sure the domain is correctly pointed to the script. By default, you will see a Domain is Working page if the domain is correctly pointed.') ?></p>
                <p><?php ee('You can now assign same domain to more than one users.') ?></p>

            </div>
        </div>
    </div>
</div>