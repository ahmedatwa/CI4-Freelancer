(function ($) {

	"use strict";

// Lazy load
var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
});

// Carousel categories home page
	$('.categories_carousel').owlCarousel({
		center: false,
		items: 2,
		loop: false,
		margin: 20,
		dots:false,
		nav: true,
		lazyLoad:true,
        navText: ["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
		responsive: {
			0: {
				nav: false,
				dots:true,
				items: 1
			},
			480: {
				nav: false,
				dots:true,
				items: 2
			},
			768: {
				nav: false,
				dots:true,
				items: 3
			},
			1025: {
				nav: false,
				dots:true,
				items: 4
			},
			1340: {
				nav: true,
				dots:false,
				items: 5
			}
		}
	});

	// Carousel home page
		$('.carousel_pro_home').owlCarousel({
			items: 4,
			loop: false,
			margin: 20,
			dots:false,
            lazyLoad:true,
			navText: ["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
			nav:true,
			responsive: {
			0: {
				items: 1,
				nav: false,
				dots:true
			},
			560: {
				items: 2,
				nav: false,
				dots:true
			},
			768: {
				items: 2,
				nav: false,
				dots:true
			},
			991: {
				items: 3,
				nav: true,
				dots:false
			}
		}
		});

	// Sticky nav
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 1) {
			$('.element_to_stick').addClass("sticky");
		} else {
			$('.element_to_stick').removeClass("sticky");
		}
	});
	$(window).scroll();

	// Header background
	$('.background-image').each(function(){
		$(this).css('background-image', $(this).attr('data-background'));
	});

	// Rotate icons
	$(".categories_carousel .item a").hover(
		function(){$(this).find("img").toggleClass("rotate-x");}
	);
	
	// Menu
	$('a.open_close').on("click", function () {
		$('.main-menu').toggleClass('show');
		$('.layer').toggleClass('layer-is-visible');
	});
	$('a.show-submenu').on("click", function () {
		$(this).next().toggleClass("show_normal");
	});
	
	// Opacity mask
	$('.opacity-mask').each(function(){
		$(this).css('background-color', $(this).attr('data-opacity-mask'));
	});

	// Scroll to top
	var pxShow = 800; // height on which the button will show
	var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.
	$(window).scroll(function(){
	 if($(window).scrollTop() >= pxShow){
		$("#toTop").addClass('visible');
	 } else {
		$("#toTop").removeClass('visible');
	 }
	});
	$('#toTop').on('click', function(){
	 $('html, body').animate({scrollTop:0}, scrollSpeed);
	 return false;
	});	
	
	//Footer collapse
	var $headingFooter = $('footer h3');
	$(window).resize(function() {
        if($(window).width() <= 768) {
      		$headingFooter.attr("data-toggle","collapse");
        } else {
          $headingFooter.removeAttr("data-toggle","collapse");
        }
    }).resize();
	$headingFooter.on("click", function () {
		$(this).toggleClass('opened');
	});

	// Scroll to position
    $('a[href^="#"].btn_scroll').on('click', function (e) {
			e.preventDefault();
			var target = this.hash;
			var $target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top
			}, 800, 'swing', function () {
				window.location.hash = target;
			});
		});

    // Header button explore
    $('a[href^="#"].btn_explore').on('click', function (e) {
			e.preventDefault();
			var target = this.hash;
			var $target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top
			}, 300, 'swing', function () {
				window.location.hash = target;
			});
		});

	// Like Icon
    $('.btn_hero.wishlist').on('click', function(e){
    	e.preventDefault();
		$(this).toggleClass('liked');
	});
	// Like Icon
    $('.wish_bt').on('click', function(e){
    	e.preventDefault();
		$(this).toggleClass('liked');
	});

	/* Tooltip */
	$('.tooltip-1').tooltip({
		html: true
	});

	// Show hide password
	$('#password, #password_sign, #password1, #password2').hidePassword('focus', {
		toggle: {
			className: 'my-toggle'
		}
	});

$('#login-button').on('click', function(){
  $.ajax({
       url: 'account/login',
       method:'post',
       dataType:'json',
       data: $('#form-login input[type=\'email\'], #form-login input[type=\'password\']'),
	   beforeSend: function() {
	   	    $('.alert, .text-danger').remove();
			$('#login-button').button('loading');
		},
		complete: function() {
			$('#login-button').button('reset');
		},
       success: function(json) {
		if (json['validator']) {
			var i;

			$('#login-body').before("<div class='alert alert-danger alert-dismissible fade show' role='alert'> <i class='fas fa-exclamation-triangle'></i> " + json['error_warning'] + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		
		for (i in json['validator']) {
			var element = $('#input-login-' + i.replace('_', '-'));

			if (element.parent().hasClass('input-group')) {
				$(element).parent().after('<div class="text-danger">' + json['validator'][i] + '</div>');
			} else {
				$(element).after('<div class="text-danger">' + json['validator'][i] + '</div>');
			}
		  }
		}
		if (json['redirect']){
			location = json['redirect'];
		}
       },
       error: function (xhr, ajaxOptions, thrownError) {
          alert("Error!", thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText , "error");
       }
  });
});
// Register
$('#register-button').on('click', function(){
  $.ajax({
       url: 'account/register',
       method:'post',
       dataType:'json',
       data: $('#form-register input[type=\'email\'], #form-register input[type=\'password\']'),
	   beforeSend: function() {
	   		$('.alert, .text-danger').remove();
			$('#register-button').button('loading');
		},
		complete: function() {
			$('#register-button').button('reset');
		},
       success: function(json) {
		if (json['validator']){
			var i;
		$('#register-body').before("<div class='alert alert-danger alert-dismissible fade show' role='alert'> <i class='fas fa-exclamation-triangle'></i> " + json['error_warning'] + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		for (i in json['validator']) {
			var element = $('#input-register-' + i.replace('_', '-'));

			if (element.parent().hasClass('input-group')) {
				$(element).parent().after('<div class="text-danger">' + json['validator'][i] + '</div>');
			} else {
				$(element).after('<div class="text-danger">' + json['validator'][i] + '</div>');
			}
		  }
		}
		if (json['success']) {
			$('#register-body').before("<div class='alert alert-success alert-dismissible fade show' role='alert'>" + json['success'] + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		if (json['redirect']) {
			location = json['redirect'];
		}
       },
       error: function (xhr, ajaxOptions, thrownError) {
          alert("Error!", thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText , "error");
       }
  });
});

})(window.jQuery); 