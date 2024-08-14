/* Validation form */
validateForm('validation-newsletter');
validateForm('validation-cart');
validateForm('validation-user');
validateForm('validation-contact');

NN_FRAMEWORK.Common = function(){
    $(".content-ck iframe,.content-ck embed").each(function(e,n){$(this).wrap("<div class='video-container'></div>")});
    $(".content-ck iframe").each(function(e,n){
		var src = $(this).attr('src');
		$(this).attr('sandbox', 'allow-same-origin allow-scripts allow-popups allow-forms');
		$(this).attr('src', src);
	});
    $(".content-ck table").each(function(e,t){$(this).wrap("<div class='table-responsive'></div>")});  
    $(".content-ck table").each(function() {
    	var value_border = $(this).attr('border');
    	if(value_border > 0){
    		$(this).find('tbody').css('border-width',value_border);
    		$(this).find('td').css('border-width',value_border);
    		$(this).find('tfoot').css('border-width',value_border);
    		$(this).find('th').css('border-width',value_border);
    		$(this).find('thead').css('border-width',value_border);
    		$(this).find('tr').css('border-width',value_border);
    	}
    });
};

/* Lazys */
NN_FRAMEWORK.Lazys = function () {
	if (isExist($('.lazy'))) {
		var lazyLoadInstance = new LazyLoad({
			elements_selector: '.lazy'
		});
	}
};

/* Back to top */
NN_FRAMEWORK.GoTop = function () {
	$(window).scroll(function () {
		if (!$('.scrollToTop').length)
			$('body').append('<div class="scrollToTop"><img src="' + GOTOP + '" alt="Go Top"/></div>');
		if ($(this).scrollTop() > 100) $('.scrollToTop').fadeIn();
		else $('.scrollToTop').fadeOut();
	});
};

/* Alt images */
NN_FRAMEWORK.AltImg = function () {
	$('img').each(function (index, element) {
		if (!$(this).attr('alt') || $(this).attr('alt') == '') {
			$(this).attr('alt', WEBSITE_NAME);
		}
	});
};

/* Menu */
NN_FRAMEWORK.Menu = function () {
	/* Menu remove empty ul */
	if (isExist($('.menu'))) {
		$('.menu ul li a').each(function () {
			$this = $(this);

			if (!isExist($this.next('ul').find('li'))) {
				$this.next('ul').remove();
				$this.removeClass('has-child');
			}
		});
	}
	if (SOURCE != 'user') {
		$(window).scroll(function(){
			if($(window).scrollTop() >= 100) 
			{   
				$(".header-bottom").addClass("menufix animate__animated animate__fadeInDown");
			}
			else 
			{   
				$(".header-bottom").removeClass("menufix animate__animated animate__fadeInDown");
			}
		});
	}

	/* Mmenu */
	if (isExist($('nav#menu'))) {
		menuMobile({search:false, lang:false});
	}
};

/* Tools */
NN_FRAMEWORK.Tools = function () {
	$('body').on('click', '.scrollToTop,.scrollToTopMobile', function () {
        $('html, body').animate({ scrollTop: 0 }, 100);
        return false;
    });
};
 /* Toolbar */
NN_FRAMEWORK.Toolbar = function(){  
	$(".toolbar .phone").click(function (e) { 
		e.stopPropagation();
		$(".toolbar").toggleClass('is-active');
	});
	$(document).click(function () {
		$(".toolbar").removeClass('is-active');
	});
	var lastScrollTop = 0;
	$(window).scroll(function () {
		var ex6Exists = $('.ex6').length > 0;
		if ($(this).scrollTop() > 100) {
			if (!ex6Exists) {
				$('.toolbar-app .scrollToTopMobile').addClass('ex6');
			}
		}else{
			$('.toolbar-app .scrollToTopMobile').removeClass('ex6');
		}

		
		var scrollTop = $(this).scrollTop();
		if (scrollTop <= lastScrollTop && scrollTop < 70) {
			$("body").addClass("show-toolbar");
			$("body").removeClass("hidden-toolbar");
			$('#check-toolbar').prop('checked', true);
		}
		lastScrollTop = scrollTop;
	});
	$("body").addClass("show-toolbar");
	$("#check-toolbar").change(function (e) { 
		if($(this).prop('checked')){
			$("body").addClass("show-toolbar");
			$("body").removeClass("hidden-toolbar");
		}else{
			$("body").removeClass("show-toolbar");
			$("body").addClass("hidden-toolbar");
		}
	});
};


/* Owl Data */
NN_FRAMEWORK.OwlData = function (obj) {
	if (!isExist(obj)) return false;
	var items = obj.attr('data-items');
	var rewind = Number(obj.attr('data-rewind')) ? true : false;
	var autoplay = Number(obj.attr('data-autoplay')) ? true : false;
	var loop = Number(obj.attr('data-loop')) ? true : false;
	var lazyLoad = Number(obj.attr('data-lazyload')) ? true : false;
	var center = Number(obj.attr('data-center')) ? true : false;
	var mouseDrag = Number(obj.attr('data-mousedrag')) ? true : false;
	var touchDrag = Number(obj.attr('data-touchdrag')) ? true : false;
	var animations = obj.attr('data-animations') || false;
	var smartSpeed = Number(obj.attr('data-smartspeed')) || 800;
	var autoplaySpeed = Number(obj.attr('data-autoplayspeed')) || 800;
	var autoplayTimeout = Number(obj.attr('data-autoplaytimeout')) || 5000;
	var dots = Number(obj.attr('data-dots')) ? true : false;
	var responsive = {};
	var responsiveClass = true;
	var responsiveRefreshRate = 200;
	var nav = Number(obj.attr('data-nav')) ? true : false;
	var navContainer = obj.attr('data-navcontainer') || false;
	var btnController = Number(obj.attr('data-btn-controler')) ? true : false;
	if(btnController == true){
		var navTextTemp = "Previous|Next";
	} else {
		var navTextTemp =
		"<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-left' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='15 6 9 12 15 18' /></svg>|<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-right' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='9 6 15 12 9 18' /></svg>";	
	}
	var navText = obj.attr('data-navtext');
	navText = nav && navContainer && (((navText === undefined || Number(navText)) && navTextTemp) || (isNaN(Number(navText)) && navText) || (Number(navText) === 0 && false));

	if (items) {
		items = items.split(',');

		if (items.length) {
			var itemsCount = items.length;

			for (var i = 0; i < itemsCount; i++) {
				var options = items[i].split('|'),
					optionsCount = options.length,
					responsiveKey;

				for (var j = 0; j < optionsCount; j++) {
					const attr = options[j].indexOf(':') ? options[j].split(':') : options[j];

					if (attr[0] === 'screen') {
						responsiveKey = Number(attr[1]);
					} else if (Number(responsiveKey) >= 0) {
						responsive[responsiveKey] = {
							...responsive[responsiveKey],
							[attr[0]]: (isNumeric(attr[1]) && Number(attr[1])) ?? attr[1]
						};
					}
				}
			}
		}
	}

	if (nav && navText) {
		navText = navText.indexOf('|') > 0 ? navText.split('|') : navText.split(':');
		navText = [navText[0], navText[1]];
	}

	obj.owlCarousel({
		rewind,
		autoplay,
		loop,
		center,
		lazyLoad,
		mouseDrag,
		touchDrag,
		smartSpeed,
		autoplaySpeed,
		autoplayTimeout,
		dots,
		nav,
		navText,
		navContainer: nav && navText && navContainer,
		responsiveClass,
		responsiveRefreshRate,
		responsive
	});

	if (autoplay) {
		obj.on('translate.owl.carousel', function (event) {
			obj.trigger('stop.owl.autoplay');
		});

		obj.on('translated.owl.carousel', function (event) {
			obj.trigger('play.owl.autoplay', [autoplayTimeout]);
		});
	}

	if (animations && isExist(obj.find('[owl-item-animation]'))) {
		var animation_now = '';
		var animation_count = 0;
		var animations_excuted = [];
		var animations_list = animations.indexOf(',') ? animations.split(',') : animations;

		obj.on('changed.owl.carousel', function (event) {
			$(this).find('.owl-item.active').find('[owl-item-animation]').removeClass(animation_now);
		});

		obj.on('translate.owl.carousel', function (event) {
			var item = event.item.index;

			if (Array.isArray(animations_list)) {
				var animation_trim = animations_list[animation_count].trim();

				if (!animations_excuted.includes(animation_trim)) {
					animation_now = 'animate__animated ' + animation_trim;
					animations_excuted.push(animation_trim);
					animation_count++;
				}

				if (animations_excuted.length == animations_list.length) {
					animation_count = 0;
					animations_excuted = [];
				}
			} else {
				animation_now = 'animate__animated ' + animations_list.trim();
			}
			$(this).find('.owl-item').eq(item).find('[owl-item-animation]').addClass(animation_now);
		});
	}
};

/* Owl Page */
NN_FRAMEWORK.OwlPage = function () {
	if (isExist($('.owl-page'))) {
		$('.owl-page').each(function () {
			NN_FRAMEWORK.OwlData($(this));
		});
	}
};


/* TOC */
NN_FRAMEWORK.Toc = function(){
    if(isExist($(".toc-list")))
    {
        $(".toc-list").toc({
            content: "div#toc-content",
            headings: "h2,h3,h4"
        });

        if(!$(".toc-list li").length) $(".meta-toc").hide();
        if(!$(".toc-list li").length) $(".meta-toc .mucluc-dropdown-list_button").hide();

        $('.toc-list').find('a').click(function(){
            var x = $(this).attr('data-rel');
            goToByScroll(x);
        });

        $("body").on("click",".mucluc-dropdown-list_button", function () {
            $(".box-readmore").slideToggle(200);
        });

        $(document).scroll(function() {
            var y = $(this).scrollTop();
            if (y > 300) {
                $('.meta-toc').addClass('fiedx');
            } else {
                $('.meta-toc').removeClass('fiedx');
            }
        });
    }
};


/* Slide */
NN_FRAMEWORK.Slide = function () {

	if (isExist($('.slick-news'))) {
		$(".slick-news").slick({
			arrows: true,
			infinite: true,
			slidesToShow: 3,
			autoplay: false,
			speed: 800,
			responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
			]
		});
	}
	if (isExist($(".slide-text"))) {
        $(".slide-text").slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 3000,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            arrows: true,
            fade: true,
        });
    }

    if (isExist($(".slick-1"))) {
        $(".slick-1").slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 3000,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            arrows: false,
            responsive: [
			{
				breakpoint: 1025,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
			]
        });
    }

    if (isExist($(".slick-vertical"))) {
        $(".slick-vertical").slick({
            dots: false,
            infinite: true,
            vertical: true,
            verticalSwiping: true,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            arrows: false,
            responsive: [
            {
				breakpoint: 481,
				settings: {
					slidesToShow: 1,
					vertical: false,
					verticalSwiping: false,
					arrows: false,
				}
			}
			]
        });
    }

    if (isExist($(".slick-3"))) {
        $(".slick-3").slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            arrows: true,
            responsive: [
            {
				breakpoint: 901,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},{
				breakpoint: 581,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
			]
        });
    }

    if (isExist($(".slick-2"))) {
        $(".slick-2").slick({
            dots: false,
            infinite: true,
            autoplaySpeed: 3000,
            slidesToShow: 2,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            arrows: true,
            responsive: [
            {
				breakpoint: 1025,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
			]
        });
    }
    if (isExist($('.slick-statistics'))) {
    	$(".slick-statistics").slick({
    		arrows: false,
    		infinite: true,
    		slidesToShow: 4,
    		autoplay: false,
    		speed: 800,
    		responsive: [
    		{
    			breakpoint: 991,
    			settings: {
    				slidesToShow: 3,
    			}
    		},
    		{
    			breakpoint: 768,
    			settings: {
    				slidesToShow: 2,
    			}
    		}
    		,
    		{
    			breakpoint: 580,
    			settings: {
    				slidesToShow: 1,
    			}
    		}
    		]
    	});
    }
};

/* Videos */
NN_FRAMEWORK.Videos = function () {
	Fancybox.bind("[data-fancybox]", {});
};


/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Common();
	NN_FRAMEWORK.Lazys();
	NN_FRAMEWORK.Tools();
	NN_FRAMEWORK.AltImg();
	NN_FRAMEWORK.GoTop();
	NN_FRAMEWORK.Menu();
	NN_FRAMEWORK.Slide();
	NN_FRAMEWORK.Toc();
	NN_FRAMEWORK.OwlPage();
	NN_FRAMEWORK.Toolbar();
	NN_FRAMEWORK.Videos();
	tippy('.note');
});

if (isExist($(".js-count-up"))) {
	function countStart(){
		const $counters = document.querySelectorAll(".js-count-up"),
		options = {
			useEasing: true,
			useGrouping: true,
			separator: "",
			decimal: "."
		};

		$counters.forEach( (item) => {
			const value = item.dataset.value;
			const counter = new CountUp(item, value, options);
			counter.start();
		});
	}

	new Waypoint({
		element: document.querySelector('.statistics'),
		handler: function() {
			countStart()
		},
		offset: '50%'
	});
}

//  Duyệt đậu các hình thức thi
$(document).on('click', '.btn-result-graduate', function(event) {
	var point = $(this).attr('data-point');
	var typeGraduate = $(this).attr('data-typedata');
	var id = $(this).attr('data-id');
	var type = "updateGraduate";
	if (point > 0) {
		$('#type-graduate').val(typeGraduate);
		$('#point-graduate').val(point);
		$('#id-student').val(id);
		$('#popup-graduate').modal('show');	
	}
	$("#form-graduate").submit(function(event) {
		var typeGraduate = $('#type-graduate').val();
		var pointGraduate = $('#point-graduate').val();
		var idStudent = $('#id-student').val();
		var type = $('#type').val();
		var noteGraduate = $('#note-graduate').val();
		$.ajax({
			url: 'api/graduation.php',
			type: 'POST',
			data: {
				typeGraduate : typeGraduate,
				pointGraduate : pointGraduate,
				idStudent : idStudent,
				noteGraduate : noteGraduate,
				type : type
			},
			success: function (result) {

				$('.result-graduate-'+idStudent+' .btn-result-graduate').addClass('dau');
				$('.result-graduate-'+idStudent+' .btn-result-graduate').text('Đậu');

				var noteHtml = '<div class="note-graduate note" data-tippy-content="'+noteGraduate+'" >Ghi chú</div>';
				$('.result-graduate-'+idStudent+' .btn-result-graduate').after(noteHtml);

				$('#form-graduate #note-graduate').val('');
				$('#popup-graduate').modal('hide');

				tippy('.note');

				showNotify("Duyệt thành công !");
			},
		});
	});
});