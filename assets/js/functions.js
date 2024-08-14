function isExist(ele) {
	return ele.length;
}

function isNumeric(value) {
	return /^\d+$/.test(value);
}

function getLen(str) {
	return /^\s*$/.test(str) ? 0 : str.length;
}

function showNotify(text = 'Notify text', title = LANG['thongbao'], status = 'success') {
	new Notify({
		status: status, // success, warning, error
		title: title,
		text: text,
		effect: 'fade',
		speed: 400,
		customClass: null,
		customIcon: null,
		showIcon: true,
		showCloseButton: true,
		autoclose: true,
		autotimeout: 3000,
		gap: 10,
		distance: 10,
		type: 3,
		position: 'right top'
	});
}

function notifyDialog(content = '', title = LANG['thongbao'], icon = 'fas fa-exclamation-triangle', type = 'blue') {
	$.alert({
		title: title,
		icon: icon, // font awesome
		type: type, // red, green, orange, blue, purple, dark
		content: content, // html, text
		backgroundDismiss: true,
		animationSpeed: 600,
		animation: 'zoom',
		closeAnimation: 'scale',
		typeAnimated: true,
		animateFromElement: false,
		autoClose: 'accept|3000',
		escapeKey: 'accept',
		buttons: {
			accept: {
				text: LANG['dongy'],
				btnClass: 'btn-sm btn-primary'
			}
		}
	});
}

function confirmDialog(action, text, value, title = LANG['thongbao'], icon = 'fas fa-exclamation-triangle', type = 'blue') {
	$.confirm({
		title: title,
		icon: icon, // font awesome
		type: type, // red, green, orange, blue, purple, dark
		content: text, // html, text
		backgroundDismiss: true,
		animationSpeed: 600,
		animation: 'zoom',
		closeAnimation: 'scale',
		typeAnimated: true,
		animateFromElement: false,
		autoClose: 'cancel|3000',
		escapeKey: 'cancel',
		buttons: {
			success: {
				text: LANG['dongy'],
				btnClass: 'btn-sm btn-primary',
				action: function () {
					if (action == 'delete-procart') deleteCart(value);
					if (action == 'delete-variation'){
						$('.variation-row-body-'+value).remove();
					}
				}
			},
			cancel: {
				text: LANG['huy'],
				btnClass: 'btn-sm btn-danger'
			}
		}
	});
}


function validateForm(ele='')
{
	if(ele)
	{
		$("."+ele).find("input[type=submit]").removeAttr("disabled");
		var forms = document.getElementsByClassName(ele);
		var validation = Array.prototype.filter.call(forms,function(form){
			form.addEventListener('submit', function(event){
				if(form.checkValidity() === false)
				{
					event.preventDefault();
					event.stopPropagation();
				}else{
					if(form.id == 'FormContact'){
						grecaptcha.execute(RECAPTCHA_SITEKEY, { action: 'contact' }).then(function(token) {
							document.getElementById("recaptchaResponseContact").value = token; 
							$('#FormContact').submit();
						});
						event.preventDefault();
						event.stopPropagation();
					}
					if(form.id == 'FormNewsletter'){
						grecaptcha.execute(RECAPTCHA_SITEKEY, { action: 'Newsletter' }).then(function(token) {
							document.getElementById("recaptchaResponseNewsletter").value = token; 
							$('#FormNewsletter').submit();
						});
						event.preventDefault();
						event.stopPropagation();
					}
					if(form.id == 'FormNewsletterIndex'){
						grecaptcha.execute(RECAPTCHA_SITEKEY, { action: 'Newsletter' }).then(function(token) {
							document.getElementById("recaptchaResponseNewsletterIndex").value = token; 
							$('#FormNewsletterIndex').submit();
						});
						event.preventDefault();
						event.stopPropagation();
					}
				}
				form.classList.add('was-validated');
			}, false);
		});
	}
}

function readImage(inputFile, elementPhoto) {
	if (inputFile[0].files[0]) {
		if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
			var size = parseInt(inputFile[0].files[0].size) / 1024;

			if (size <= 4096) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$(elementPhoto).attr('src', e.target.result);
				};
				reader.readAsDataURL(inputFile[0].files[0]);
			} else {
				notifyDialog(LANG['dungluonghinhanhlon']);
				return false;
			}
		} else {
			$(elementPhoto).attr('src', '');
			notifyDialog(LANG['dinhdanghinhanhkhonghople']);
			return false;
		}
	} else {
		$(elementPhoto).attr('src', '');
		return false;
	}
}

function photoZone(eDrag, iDrag, eLoad) {
	if ($(eDrag).length) {
		/* Drag over */
		$(eDrag).on('dragover', function () {
			$(this).addClass('drag-over');
			return false;
		});

		/* Drag leave */
		$(eDrag).on('dragleave', function () {
			$(this).removeClass('drag-over');
			return false;
		});

		/* Drop */
		$(eDrag).on('drop', function (e) {
			e.preventDefault();
			$(this).removeClass('drag-over');

			var lengthZone = e.originalEvent.dataTransfer.files.length;

			if (lengthZone == 1) {
				$(iDrag).prop('files', e.originalEvent.dataTransfer.files);
				readImage($(iDrag), eLoad);
			} else if (lengthZone > 1) {
				notifyDialog(LANG['banchiduocchon1hinhanhdeuplen']);
				return false;
			} else {
				notifyDialog(LANG['dulieukhonghople']);
				return false;
			}
		});

		/* File zone */
		$(iDrag).change(function () {
			readImage($(this), eLoad);
		});
	}
}

function generateCaptcha(action, id) {
	if (RECAPTCHA_ACTIVE && action && id && $('#' + id).length) {
		grecaptcha.execute(RECAPTCHA_SITEKEY, { action: action }).then(function (token) {
			var recaptchaResponse = document.getElementById(id);
			recaptchaResponse.value = token;
		});
	}
}

function loadPaging(url = '', eShow = '') {
	if ($(eShow).length && url) {
		$.ajax({
			url: url,
			type: 'GET',
			data: {
				eShow: eShow
			},
			success: function (result) {
				$(eShow).html(result);
				NN_FRAMEWORK.Lazys();
			}
		});
	}
}

function loadPagingIndex(url = '', eShow = '') {
	if ($(eShow).length && url) {
		$.ajax({
			url: url,
			type: 'GET',
			data: {
				eShow: eShow
			},
			success: function (result) {
				$(eShow).html(result);
				NN_FRAMEWORK.Lazys();
			}
		});
	}
}

function loadPaging(url = '', eShow = '') {
	if ($(eShow).length && url) {
		$.ajax({
			url: url,
			type: 'GET',
			data: {
				eShow: eShow
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				$(eShow).html(result);
				NN_FRAMEWORK.Lazys();
				holdonClose();
			}
		});
	}
}

function doEnter(event, obj) {
	if (event.keyCode == 13 || event.which == 13) onSearch(obj);
}

function onSearch(obj) {
	var keyword = $('#' + obj).val();

	if (keyword == '') {
		notifyDialog(LANG['no_keywords']);
		return false;
	} else {
		location.href = 'tim-kiem?keyword=' + encodeURI(keyword);
	}
}

function goToByScroll(id, minusTop) {
	minusTop = parseInt(minusTop) ? parseInt(minusTop) : 0;
	id = id.replace('#', '');
	$('html,body').animate(
	{
		scrollTop: $('#' + id).offset().top - minusTop
	},
	'slow'
	);
}

function holdonOpen(theme = 'sk-circle',text = 'Loading...',backgroundColor = 'rgba(0,0,0,0.8)',textColor = 'white') {
	var options = {
		theme: theme,
		message: text,
		backgroundColor: backgroundColor,
		textColor: textColor
	};

	HoldOn.open(options);
}

function holdonClose() {
	HoldOn.close();
}
function updateCart(id = 0, color = 0, size = 0, code = '', quantity = 1) {
    if (id) {
        var formCart = $('.form-cart');
        var ward = formCart.find('.select-ward-cart').val();

        $.ajax({
            type: 'POST',
            url: 'api/cart.php',
            dataType: 'json',
            data: {
                cmd: 'update-cart',
                id: id,
                color: color,
                size: size,
                code: code,
                quantity: quantity,
                ward: ward
            },
            beforeSend: function () {
                holdonOpen();
            },
            success: function (result) {
                if (result) {
                    formCart.find('.load-price-' + code).html(result.regularPrice);
                    formCart.find('.load-price-new-' + code).html(result.salePrice);
                    formCart.find('.load-price-temp').html(result.tempText);
                    formCart.find('.load-price-total').html(result.totalText);
                }
                holdonClose();
            }
        });
    }
}

function deleteCart(obj) {
	var formCart = $('.form-cart');
	var code = obj.data('code');
	var ward = formCart.find('.select-ward-cart').val();

	$.ajax({
		type: 'POST',
		url: 'api/cart.php',
		dataType: 'json',
		data: {
			cmd: 'delete-cart',
			code: code,
			ward: ward
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			$('.count-cart').html(result.max);
			if (result.max) {
				formCart.find('.load-price-temp').html(result.tempText);
				formCart.find('.load-price-total').html(result.totalText);
				formCart.find('.procart-' + code).remove();
			} else {
				$('.wrap-cart').html(
					'<div class="empty-cart text-decoration-none"><i class="fa-duotone fa-cart-xmark"></i><p>' +
					LANG['no_products_in_cart'] +
					'</p><a href="" class="btn btn-warning">' +
					LANG['back_to_home'] +
					'</a></div>'
					);
			}
			holdonClose();
		}
	});
}

function loadDistrict(id = 0) {
	holdonOpen();
	fetch(CONFIG_BASE+`assets/jsons/district-`+id+`.json`,{headers: {"Content-Type": "application/json"}}).then(response => {
		return response.json();
	}).then(function(data) {
		$('.select-district').html(`<option value="">`+LANG['district']+`</option>`);
		$('.select-ward').html('<option value="">' + LANG['ward'] + '</option>');
		$.each(data, function(index, val) {
			$('.select-district').append(`<option value="`+val.id+`">`+val.name+`</option>`);
		});
		holdonClose()
	}).catch(error => {
		showNotify(LANG['dangcapnhatdulieu']);
		holdonClose();
	});
}

function loadWard(city = 0,id = 0) {
	holdonOpen();
	fetch(CONFIG_BASE+`assets/jsons/wards-`+city+`-`+id+`.json`,{headers: {"Content-Type": "application/json"}}).then(response => {
		return response.json();
	}).then(function(data) {
		$('.select-ward').html(`<option value="">`+LANG['ward']+`</option>`);
		$.each(data, function(index, val) {
			$('.select-ward').append(`<option value="`+val.id+`">`+val.name+`</option>`);
		});
		holdonClose()
	}).catch(error => {
		showNotify(LANG['dangcapnhatdulieu']);
		holdonClose();
	});
}

function loadShip(id = 0) {
	if (SHIP_CART) {
		var formCart = $('.form-cart');

		$.ajax({
			type: 'POST',
			url: 'api/cart.php',
			dataType: 'json',
			data: {
				cmd: 'ship-cart',
				id: id
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				if (result) {
					formCart.find('.load-price-ship').html(result.shipText);
					formCart.find('.load-price-total').html(result.totalText);
				}
				holdonClose();
			}
		});
	}
}
function loadVariationOther(id = 0, id_pro = 0, table, numb, id_other = 0) {
	if (id > 0) {
		$.ajax({
			type: 'POST',
			url: 'api/variation.php',
			type: 'post',
			data: {
				act: 'load',
				id: id,
				id_pro: id_pro,
				table: table,
				id_other: id_other
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				if(table == 'size') $('#variation-color-'+numb).html(result);
				else $('#variation-size-'+numb).html(result);
				holdonClose();
			}
		});
	}
}

function FirstLoadAPI(div, url, name_api) {
	$(div).addClass('active');
	var id = $(div).data('id');
	var tenkhongdau = $(div).data('tenkhongdau');
	FrameAjax(url, "POST", {
		id: id,
		tenkhongdau: tenkhongdau
	}, name_api);
}

function LoadAPI(div, url, name_api) {
	$(div).click(function(event) {
		$(div).removeClass('active');
		$(this).addClass('active');
		var id = $(this).data('id');
		var tenkhongdau = $(this).data('tenkhongdau');
		FrameAjax(url, "POST", {
			id: id,
			tenkhongdau: tenkhongdau
		}, name_api);
	});
}

function FrameAjax(url, type, data, name) {
	$.ajax({
		url: url,
		type: type,
		data: data,
		success: function(data) {
			$(name).html(data);
			NN_FRAMEWORK.Lazys();
		}
	});
}
function getPriceVariation(parents, id_pro, id_color, id_size, quantity = 1){
	var isImages = false;
	$.getJSON(PATH_JSON + 'variation-'+id_pro+'.json?v=' + stringRandom(5), function(data) {
		parents.find('.size-pro-detail').removeClass('disable');
		parents.find('.color-pro-detail').removeClass('disable');
		$.each(data, function(index, val) {
			if(val['id_color'] == id_color && val['id_color'] != "" && isImages == true){
				var imageColor = CONFIG_BASE + "thumbs/540x540x1/upload/product/" + val['photo'];
				$('#Zoom-1').attr('href', imageColor).attr('data-image', imageColor);
				$('#Zoom-1 img').attr('src', imageColor);
				MagicZoom.refresh('Zoom-1');
				isImages = false;
			}
			if(val['id_color'] == id_color && val['id_size'] == id_size){
				if(val['sale_price'] > 0){
					parents.find('.price-new-pro-detail').html(formatPrice(val['sale_price']));
					parents.find('.price-old-pro-detail').html(formatPrice(val['regular_price']));
				}else{
					parents.find('.price-new-pro-detail').html(formatPrice(val['regular_price'] * quantity));
					parents.find('.price-old-pro-detail').html('');
				}
			}
			if(val['id_color'] == id_color && val['status'] == 0){
				parents.find('.size-pro-detail-'+val['id_size']).addClass('disable');
			}
			if(val['id_size'] == id_size && val['status'] == 0){
				parents.find('.color-pro-detail-'+val['id_color']).addClass('disable');
			}
		});
	});
	return false;
}

function formatPrice(price) {
	const amount = Math.abs(Number(price)) || 0;
	const parts = amount.toFixed(0).split('.');
	const formattedAmount = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	const formattedPrice = formattedAmount + ' đ';

	return formattedPrice;
}

/* Radndom */
function stringRandom(length) {
	var result = '';
	var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;

	for (var i = 0; i < length; i++) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}

	return result;
}


/* Filter Search  */
function searchTeacher(url) {
	var listid = '';
	
	var courses_id = '';
	var courses_name = '';
	var student_name = '';
	var student_id = '';
	var student_cmt = '';
	var id_post = $('#courses_id').val();
	var name_post = $('#courses_name').val();
	var gplx = $('#gplx').val();
	var hangxe = $('#hangxe').val();
	var function_teacher = $('#function_teacher').val();
	var student_name_post = $('#student_name').val();
	var student_id_post = $('#student_id').val();
	var student_cmt_post = $('#student_cmt').val();
	var status_pass = $('#status_pass').val();

	$(".result-btn").each(function() {
		var id = $(this).attr('data-result'); 
		var category = $(this).attr('data-category');
		if(id){
			if(category == 'courses_id'){
				courses_id += id+",";
			}
			if(category == 'courses_name'){
				courses_name += id+",";
			}
			if(category == 'student_name'){
				student_name += id+",";
			}
			if(category == 'student_id'){
				student_id += id+",";
			}
			if(category == 'student_cmt'){
				student_cmt += id+",";
			}
		}
	})
	if(courses_id=='' || id_post == ''){
		courses_id = courses_id.substring(0, courses_id.length-1);
	}	
	if(courses_name=='' || name_post == ''){
		courses_name = courses_name.substring(0, courses_name.length-1);
	}	
	
	if(student_name=='' || student_name_post == ''){
		student_name = student_name.substring(0, student_name.length-1);
	}
	
	if(student_id=='' || student_id_post == ''){
		student_id = student_id.substring(0, student_id.length-1);
	}
	if(student_cmt=='' || student_cmt_post == ''){
		student_cmt = student_cmt.substring(0, student_cmt.length-1);
	}

	if (id_post || courses_id) url += '&courses-id=' + encodeURI(courses_id + id_post);
	if (name_post || courses_name) url += '&courses-name=' + encodeURI(courses_name + name_post);
	if (student_name_post || student_name) url += '&student-name=' + student_name + student_name_post;
	if (student_id_post || student_id) url += '&student-id=' + student_id + student_id_post;
	if (student_cmt_post || student_cmt) url += '&student-cmt=' + student_cmt + student_cmt_post;
	if (gplx > 0) url += '&gplx=' + gplx;
	if (status_pass > 0) url += '&status-pass=' + status_pass;

	window.location = url;
}

function parseJwt(token) {
	var base64Url = token.split('.')[1];
	var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
	var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
		return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
	}).join(''));
	return JSON.parse(jsonPayload);
}

function handleCredentialResponse(response) {
	var profile = parseJwt(response.credential);
	$gg_id = profile.iat;
	$gg_name = profile.name;
	$gg_img = profile.picture;
	$gg_email = profile.email;

	$.ajax({
		type: "POST",
		data: {
			'id': $gg_id,
			'name': $gg_name,
			'img': $gg_img,
			'mail': $gg_email,
			cmt: 'google'
		},
		url: 'api/loginsocial.php',
		dataType: 'json',
		beforeSend: function() {
			holdonOpen();
		},
		success: function(msg) {
			if(msg.hienthi == 0){
				holdonClose();
				notifyDialog('Tài khoản của bạn đã hết hạn đăng nhập hoặc đã đăng nhập trên thiết bị khác');
			}else{
				if (msg.status == 1) {
					
					window.location.href = msg.back;
				} else {
					location.reload();
				}
			}
		}
	});
}

window.onload = function() {
	google.accounts.id.initialize({
		client_id: "822438318618-opr1lqirn7scd4eeihki31cqg8olu2ug.apps.googleusercontent.com",
		callback: handleCredentialResponse,
	});

	google.accounts.id.renderButton(
		document.querySelector(".login_gg"), {
			theme: "outline",
			size: "large"
		}
		);
}
