<div class="d-flex">
    <div>
        <h1 class="h3 mb-5 fw-bold"><?php ee('Integrations Settings') ?></h1>
    </div>
    <div class="ms-auto">
        
    </div>
</div>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">      
        <div class="d-flex mb-3">
            <h4 class="fw-bold mb-0"><?php ee('Slack Integration') ?></h4>
            <div class="ms-auto">
                <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#manifest" class="btn btn-primary"><?php ee('Quick Slack Setup') ?></a>        
            </div>
        </div> 
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <p><?php ee('To enable slack integration, setup the following fields. If you leave the following fields empty, slack integration will be disabled. For documentation on how to setup Slack, please see <a href="https://gemp.me/docs" target="_blank">https://gemp.me/docs</a>') ?></p>
                    <div class="form-group">
					    <label class="form-label fw-bold"><?php ee('Slack Request URL') ?></label>
                        <input type="text" class="form-control p-2" value="<?php echo route("webhook", ['slack']) ?>" disabled>
                        <p class="form-text"><?php ee('You need to add this in the the slack "Apps".') ?></p>
                    </div>							
                    <div class="form-group">
					    <label for="slackclientid" class="form-label fw-bold"><?php ee('Slack Client ID') ?></label>
                        <input type="text" class="form-control p-2" name="slackclientid" value="<?php echo config('slackclientid') ?>">
                        <p class="form-text"><?php ee('You can find your slack client id in the slack "Apps".') ?></p>
                    </div>	
                    <div class="form-group">
					    <label for="slacksecretid" class="form-label fw-bold"><?php ee('Slack Client Secret') ?></label>
                        <input type="text" class="form-control p-2" name="slacksecretid" value="<?php echo config('slacksecretid') ?>">
                        <p class="form-text"><?php ee('You can find your slack secret id in the slack "Apps".') ?></p>
                    </div>
                    <div class="form-group">
					    <label for="slacksigningsecret" class="form-label fw-bold"><?php ee('Slack Signing Secret') ?></label>
                        <input type="text" class="form-control p-2" name="slacksigningsecret" value="<?php echo config('slacksigningsecret') ?>">
                        <p class="form-text"><?php ee('You can find your slack secret id in the slack "Apps". This is used to validate requests from Slack.') ?></p>
                    </div>					  	
                    <div class="form-group">
					    <label for="slackcommand" class="form-label fw-bold"><?php ee('Slack Command') ?></label>
                        <input type="text" class="form-control p-2" name="slackcommand" value="<?php echo config('slackcommand') ?>">
                        <p class="form-text"><?php ee('Insert the command that you choose in the slack app settings. It has to be the same as the one you choose. For more information, please see docs.') ?></p>
                    </div>			                    
                    <button type="submit" class="btn btn-success"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>        
    </div>
</div>
<div class="modal fade" id="manifest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Quick Setup') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
            <?php ee('Premium URL Shortener can generate an App Manifest for you, making it very easy for you to setup a Slack app.') ?>
        </p>
        <ol>
            <li><?php ee('Create a new App in Slack') ?></li>
            <li><?php ee('Grab your <strong>Client ID, Secret and Signing Secret</strong> and paste them in their respective fields.') ?></li>
            <li><?php ee('Choose your custom command in <strong>Slack Command</strong> and Save') ?></li>
            <li><?php ee('Come back here and click <strong>Download Manifest</strong> below') ?></li>
            <li><?php ee('Open the downloaded JSON file in a text editor and copy the code') ?></li>
            <li><?php ee('Go to <strong>Slack > Settings > App Manifest > JSON</strong> and paste the code and Save Changes') ?></li>
        </ol>

        <a href="?manifest=true" class="btn btn-success"><?php ee('Download Manifest') ?></a>
      </div>
    </div>
  </div>
</div>