$(document).ready(function(){
    'use strict';

    $('[data-trigger=server-form]').submit(function(e){
        e.preventDefault();
        let action = $(this).attr('action');
        let valid = true;

        $('.form-control').removeClass('is-invalid');

        $(this).find('[required]').each(function(){

            let min = $(this).attr('min') ? $(this).attr('min') : 3;

            if($(this).val().length < min){
                valid = false;
                $(this).addClass('is-invalid');
                if($(this).data('error')) {
                    $.notify({
                        message: $(this).data('error')
                    },{
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                    });
                }
            }
        });

        if(valid == false) return false;

        $.ajax({
            type: 'POST',
            url: action,
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('body').append('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            complete: function(){
                $('.preloader').remove();
            },
            success: function(response){
                $('input[name=_token]').val(response.token);
                if(response.error){
                    $.notify({
                        message: response.message
                    },{
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                    });
                } else {
                    $.notify({
                        message: response.message
                    },{
                        type: 'success',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                    });
                    if(typeof response.html !== 'undefined'){
                        $('body').append(response.html);
                    }
                    $(this).find('input,textarea').val('');
                }
            }
        });
    });

    $('[data-trigger=shorten-form]').submit(function(e){
        e.preventDefault();
        let form = $(this);
        let action = form.attr('action');
        let data = new FormData(this);
        let file = $('#metaimage');

        $('.form-control').removeClass('is-invalid');
        $('#return-error .alert').remove();

        if($("input[name=multiple]").val() == "1"){
            var url = form.find("#urls");
        }else{
            var url = form.find("#url");
        }

        if(url.val().length == 0){
            $.notify({message: lang.error},{type: 'danger',placement: {from: "top",align: "left"}});
            $('#url,#urls').addClass('is-invalid');
            return false;
        }

        if($("#metaimage").length > 0 && file.get(0).files.length != 0 && file.get(0).files[0].size > 1*1024*1024){
            if(["image/jpeg", "image/jpg"].includes(file.get(0).files[0].type) == false){
                $.notify({message: lang.imageerror},{type: 'danger',placement: {from: "top",align: "left"}});
                return false;
            }
        }

        let text = form.find('button[type=submit]').text();
        $.ajax({
            type: 'POST',
            url: action,
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function(){
                form.find('button[type=submit]').html('<div class="preloader"><div class="spinner-border spinner-border-sm text-white" role="status"><span class="sr-only">Loading...</span></div></div>').attr('disabled', 'disabled');
            },
            complete: function(){
                $('.preloader').remove();
                form.find('button[type=submit]').text(text).removeAttr('disabled');
            },
            success: function(response){
                if(response.error){
                    return $.notify({message: response.message},{type: 'danger',placement: {from: "top",align: "left"}});
                }
                let shorturl = response.data.shorturl;
                $.notify({message: response.message},{type: 'success',placement: {from: "top",align: "left"}});

                if($("input[name=multiple]").val() == "1"){
                    refreshlinks();
                    return url.val(response.data);
                }

                if($('#output-result').length > 0){
                    $('#output-result #qr-result').html('<span class="p-2 bg-light border border-success d-inline-block rounded"><img src="'+shorturl+'/qr" width="100" class="rounded"></span>');
                    $('#output-result').removeClass('d-none');
                }

                if($('#quickshortener').length > 0 && $('#quickshortener').hasClass('show')) {
                    $('#quickshortener [data-bs-dismiss=modal]').click();
                }

                if($('#successModal').length > 0){
                    triggerShortModal(shorturl);
                    refreshlinks();
                    $("#advancedOptions").removeClass('show');
                    form.find('input,textarea').val('');
                } else {
                    url.val(shorturl);

                    form.find("[type=submit]").addClass('d-none');
                    form.find("[type=button]").attr("data-clipboard-text", shorturl).removeClass('d-none');
                    $("#advancedOptions").removeClass('show');

                    new ClipboardJS('[data-trigger=shorten-form] [type=button]').on('success', function(){
                        form.find("[type=submit]").removeClass('d-none');
                        form.find("[type=button]").addClass('d-none');
                        form.find("input[type!='hidden'],textarea").val('');
                    });
                }
            }
        });
    });

    $("#search").submit(function(e){
        e.preventDefault();
        var val = $(this).find("input[type=text]").val();
        var action = $(this).attr("action");
          $.ajax({
              type: "GET",
              url: action,
              data: "q="+val,
              beforeSend: function() {
                $("#return-ajax").html('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
              },
              complete: function() {
                $('.preloader').fadeOut("fast", function(){$(this).remove()});
              },
              success: function (response) {
                $("#return-ajax").html(response);
                $("#link-holder").slideUp('fast');
                $("#return-ajax").slideDown('fast');
                feather.replace();
              }
          });
    });

    $(document).on('click', '[data-trigger=archiveselected]', function(e){
        e.preventDefault();
        let ids = [];
		$('[data-dynamic]').each(function(){
			if($(this).prop('checked')) ids.push($(this).val());
		});

        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            data: "selected="+JSON.stringify(ids),
            beforeSend: function() {
              $("#return-ajax").html('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            complete: function() {
              $('.preloader').fadeOut("fast", function(){$(this).remove()});
            },
            success: function (response) {
                if(response.error){
                    return $.notify({message: response.message},{type: 'danger',placement: {from: "bottom",align: "right"}});
                }
                $.notify({message: response.message},{type: 'success',placement: {from: "bottom",align: "right"}});
                refreshlinks(ids);
                feather.replace();
                if(typeof response.html !== 'undefined'){
                    $('body').append(response.html);
                }
            }
        });
    });

    $(document).on('change', "#payment-form select", function(){
        var $total = $("#total");
        $.ajax({
            type: "GET",
            url: $("#taxrate").data('url'),
            data: "country="+$(this).val()+"&coupon="+$("#coupon").val(),
            success: function (response) {
              if(!response.error){
                $("#taxrate").html(response.html);
				$total.text(response.newprice);
              }
            }
        });
    });
    $('#payment-form').submit(function(){
        $(this).find('button[type=submit]').attr('disabled','disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    });
    $('[data-blockid]').click(function(e){
        e.preventDefault();
        let t = $(this);
        let id = $(this).data('blockid');
        let href = $(this).attr('href');
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: "action=clicked&blockid="+id,
        }).then(function(){
            if(t.attr('target')){
                window.open(href, '_blank');
            } else {
                window.location = href;
            }
        });
    });
    $(document).on('change','#deeplink\\[enabled\\]', function(){
		if($(this).prop('checked')){

            if($('#url').val().length == 0){
                $.notify({message: lang.error},{type: 'danger',placement: {from: "top",align: "left"}});
                $('#url,#urls').addClass('is-invalid');
                $(this).prop('checked', false);
                return false;
            }

            $.ajax({
                type: "GET",
                url: $("#deeplink\\[enabled\\]").data('server')+'?url='+encodeURIComponent($('#url').val()),
                success: function (response) {

                    if(response.error){
                        return $.notify({message: response.message},{type: 'danger',placement: {from: "top",align: "left"}});
                    } else {
                        if(response.data){
                            $.notify({message: response.message},{type: 'success',placement: {from: "top",align: "left"}});
                            $('[data-label=device]').before('<div class="deeplinked input-group mb-3"><span class="input-group-text bg-transparent fw-bold">iPhone</span><input class="form-control" type="hidden" name="device[]" value="iPhone"><input class="form-control p-2" type="text" name="dtarget[]" value="'+response.data.ios+'"></div>');
                            $('[data-label=device]').before('<div class="deeplinked input-group mb-3"><span class="input-group-text bg-transparent fw-bold">iPad</span><input class="form-control" type="hidden" name="device[]" value="iPad"><input class="form-control p-2" type="text" name="dtarget[]" value="'+response.data.ios+'"></div>');
                            $('[data-label=device]').before('<div class="deeplinked input-group mb-3"><span class="input-group-text bg-transparent fw-bold">Android</span><input class="form-control" type="hidden" name="device[]" value="Android"><input class="form-control p-2" type="text" name="dtarget[]" value="'+response.data.android+'"></div>');     
                            $('#deelinkapple').val(response.data.iosapp);
                            $('#deelinkgoogle').val(response.data.androidapp);
                        }
                    }
                }
            });
		} else {
			$('.deeplinked').remove();
		}
	});

    $('input[name=bioalias]').on('input', function(){
        let alias = $(this).val();
        let check = $(this).data('check');

        if(alias.length >= 3) {
            $.ajax({
                type: 'get',
                url: check, 
                data: 'alias='+alias,
                success: function(response){
                    if(response.available) {
                        $('input[name=bioalias]').removeClass('is-invalid').addClass('is-valid');
                        $('.alias-feedback').removeClass('invalid-feedback').addClass('valid-feedback').text('This alias is available');
                        $('input[name=bioalias]').next('.btn').removeAttr('disabled', 'disabled');
                    } else {
                        $('input[name=bioalias]').removeClass('is-valid').addClass('is-invalid');
                        $('.alias-feedback').removeClass('valid-feedback').addClass('invalid-feedback').text('This alias is already taken');
                        $('input[name=bioalias]').next('.btn').attr('disabled', 'disabled');
                    }
                }
            });
        } else {
            $('input[name=bioalias]').removeClass('is-valid is-invalid');
            $('.alias-feedback').text('');
            $('input[name=bioalias]').next('.btn').removeAttr('disabled', 'disabled');
        }
    });

});

function refreshlinks(ids = null){

    if($("#link-holder").length < 1) return false;

    if(ids){
        ids.forEach(function(item){
            $.ajax({
                type: "GET",
                url: $("#link-holder").data('fetch')+'?id='+item,
                success: function (response) {
                  $("#link-"+item).html(response);
                  feather.replace();
                }
            });
        });
    } else {
        $.ajax({
            type: "GET",
            url: $("#link-holder").data('refresh'),
            success: function (response) {
              $("#link-holder").html(response);
              feather.replace();
            }
        });
    }
}

function triggerShortModal(shorturl){
    $('#successModal #modal-input').val(shorturl);
    $('#successModal .modal-qr p').html('<img src="'+shorturl+'/qr" width="150" class="rounded">');
    $('#successModal .copy').attr('data-clipboard-text', shorturl);
    $('#successModal #downloadPNG').attr('href', shorturl+'/qr/download/png/1000');
    $('#successModal ul li').filter(':first-child').find('a').attr('href', shorturl+'/qr/download/pdf/1000');
    $('#successModal ul li').filter(':nth-child(2)').find('a').attr('href', shorturl+'/qr/download/svg/1000');
    $('#successModal #modal-share a').each(function(){
        let href = $(this).attr('href');
        $(this).attr('href', $(this).data('href')+encodeURI(shorturl));
    })

    new ClipboardJS('#successModal .copy', {
        container: document.getElementById('successModal')
    }).on('success', function(){
        $('#successModal .copy').text(lang.copy);
    });
    new bootstrap.Modal(document.getElementById('successModal')).show();
}