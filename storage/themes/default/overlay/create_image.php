<div class="d-flex">
	<i class="icon-45" data-feather="<?php echo $icon ?>" data-bs-toggle="tooltip" title="<?php echo $name ?>"></i>
	<div class="ms-3">
		<h1 class="h3 mb-2 fw-bold"><?php echo $name ?></h1>
		<p class="text-muted mb-4"><?php echo $description ?></p>
	</div>
</div>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.save", [$type]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off" class="mb-2">
			<div class="card shadow-sm">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Promo" value="<?php echo old('name') ?>" data-required="true">
							</div>	
						</div>	
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link" class="form-label fw-bold"><?php ee("Link") ?></label>
                                <input type="text" class="form-control p-2" id="link" name="link"  value="<?php echo old('link') ?>">
                                <p class="form-text"><?php ee("If you add a link here, the whole overlay will be linked to this when clicked.") ?></p>
                            </div>
                        </div>					
					</div>
					<div class="row mb-3">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="logo" class="form-label fw-bold"><?php ee("Logo") ?></label>
								<input type="file" class="form-control p-2" id="logo" name="logo">
								<p class="form-text"><?php ee("Logo should be square with a maximum size of 100x100. To remove the image, click on the upload field and then cancel it.") ?></p>
							</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image" class="form-label fw-bold"><?php ee("Background Image") ?></label>
                                <input type="file" class="form-control p-2" id="image" name="image">
                                <p class="form-text"><?php ee("Image should be rectangle with a maximum size of 600x150. To remove the image, click on the upload field and then cancel it.") ?></p>
                            </div>								
                        </div>
                    </div>                    
				</div>                
			</div>
			<div class="card shadow-sm">
				<div class="card-header mt-2">					
					<a href="" data-bs-toggle="collapse" role="button" data-bs-target="#custom"><h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <span class="align-middle"><?php ee('Appearance Customization') ?></span></h5></a>
				</div>				
				<div class="card-body collapse" id="custom">					
					<div class="row">						
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="bg"><?php ee("Overlay Background Color") ?></label> <br>
								<input type="text" name="bg" id="bg" value="<?php echo old('bg') ?>">
							</div>			
						</div>
					</div>				
					<div class="form-group">
						<label class="form-label fw-bold d-block" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control p-2" data-toggle="select">
							<option value="tl"><?php ee("Top Left") ?></option>
							<option value="tr"><?php ee("Top Right") ?></option>                            
							<option value="bl"><?php ee("Bottom Left") ?></option>
							<option value="br" selected><?php ee("Bottom Right") ?></option> 
							<option value="bc"><?php ee("Bottom Center") ?></option> 
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Create") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">
			<div class="custom-message custom-bg position-relative bottom-0 mx-0 mt-0" style="background-color: #008aff">
				<div class="d-flex">
					<div class="custom-img"></div>
				</div>
			</div>
        </div>		
    </div>
</div>