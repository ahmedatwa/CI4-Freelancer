(function($) {
"use strict";

$(document).ready(function() {
// Search 
$('#search-container button').on('click', function() {

	var url  = '/projects';
    
    var search = $('.intro-search-field input').val();
    if (search) {
        url += '?keyword=' + encodeURIComponent(search);
    }
    
    location = url;
});

$('.intro-search-field input').on('keydown', function(e) {

	if (e.keyCode == 13) {
	    $('.intro-search-field button').trigger('click');
	}
});

// Currency
$('#form-currency #currency-list').on('change', function(e) {
	e.preventDefault();
	$('#form-currency input[name=\'code\']').val($(this).val());

	$('#form-currency').submit();
});

// Language 
$('#form-language #language-list').on('change', function(e) {
	e.preventDefault();
	$('#form-language input[name=\'code\']').val($(this).val());
	
	var redirect = $(this).children('option:selected').data('redirect');
	$('#form-language input[name=\'redirect\']').val(redirect);

	$('#form-language').submit();
});

$("[data-trigger]").on("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    var offcanvas_id =  $(this).attr('data-trigger');
    $(offcanvas_id).toggleClass("show");
    $('body').toggleClass("offcanvas-active");
    $(".screen-overlay").toggleClass("show");
}); 

$(".btn-close, .screen-overlay").click(function(e){
    $(".screen-overlay").removeClass("show");
    $(".mobile-offcanvas").removeClass("show");
    $("body").removeClass("offcanvas-active");
}); 

// Mobile Menu
$("[data-trigger]").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        $('#navbar_main').addClass("show");
        $('body').addClass("offcanvas-active");
        $(".screen-overlay").addClass("show");
    }); 

   	// Close menu when pressing ESC
    $(document).on('keydown', function(event) {
        if(event.keyCode === 27) {
           $(".mobile-offcanvas").removeClass("show");
           $("body").removeClass("overlay-active");
        }
    });

    $(".btn-close, .screen-overlay").click(function(e){
    	$(".screen-overlay").removeClass("show");
        $(".mobile-offcanvas").removeClass("show");
        $("body").removeClass("offcanvas-active");


    }); 

// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});
	
	/*----------------------------------------------------*/
	/*  Back to Top
	/*----------------------------------------------------*/

	// Button
	function backToTop() {
		$('body').append('<div id="backtotop"><a href="#"></a></div>');
	}
	backToTop();

	// Showing Button
	var pxShow = 600; // height on which the button will show
	var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.

	$(window).scroll(function(){
	 if($(window).scrollTop() >= pxShow){
		$("#backtotop").addClass('visible');
	 } else {
		$("#backtotop").removeClass('visible');
	 }
	});

	$('#backtotop a').on('click', function(){
	 $('html, body').animate({scrollTop:0}, scrollSpeed);
	 return false;
	});
	
    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function() {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });

    // Dismiss Alerts
    setTimeout(function() { 
    	$('.alert-dismissible').alert('dispose');
    }, 7000);
	/*--------------------------------------------------*/
	/*  Ripple Effect
	/*--------------------------------------------------*/
	$('.ripple-effect, .ripple-effect-dark').on('click', function(e) {
		var rippleDiv = $('<span class="ripple-overlay">'),
			rippleOffset = $(this).offset(),
			rippleY = e.pageY - rippleOffset.top,
			rippleX = e.pageX - rippleOffset.left;

		rippleDiv.css({
			top: rippleY - (rippleDiv.height() / 2),
			left: rippleX - (rippleDiv.width() / 2),
			// background: $(this).data("ripple-color");
		}).appendTo($(this));

		window.setTimeout(function() {
			rippleDiv.remove();
		}, 800);
	});


/*--------------------------------------------------*/
	/*  Notification Messages
/*--------------------------------------------------*/
	// refresh notification count
	  function totalUnseen() {
	   $.ajax({
	      url: 'account/message/getTotalUnseenMessages',
	      dataType: 'json',
	      success: function(json) {
	          if (json['total']) {
	               $('#nav-user-main #message-count').html('<span>' + json['total'] + '</span>');
	           } 
	        }
	    });
	 }totalUnseen();
	// get Live Notification Alerts
	function totalNotifications() {
	   $.ajax({
	      url: 'account/notifications/getTotalNotifications',
	      dataType: 'json',
	      success: function(json) {
	          if (json['total']) {
	               $('#nav-user-main #notifications-count').html('<span>' + json['total'] + '</span>');
	           } 
	        }
	    });
	 }totalNotifications();

	setInterval(function() {
	   totalUnseen();
	   totalNotifications();
	}, 7000);

	$('#nav-user-main #headerLoginDropdown').on('click', function() {
		$.ajax({
	      url: 'common/header/getCustomerBalace',
	      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'X-Requested-With': 'XMLHttpRequest'
          },
	      dataType: 'json',
	      method: 'post',
	      beforeSend: function() {
	      	$('#nav-user-main #customer-balance').html('<i class="fas fa-spinner fa-spin"></i>'); 
	      },
	      complete: function() {
	      	$('.fa-spinner').remove();
	      },
	      success: function(json) {
	          if (json['total']) {
	               $('#nav-user-main #customer-balance').html(json['total']);
	           } 
	        }
	    });
	});

	$('#nav-user-main #header-messages').on('click', function(e) {
	  e.preventDefault();
	  loadMessages();
	});
	$('#nav-user-main #header-notifications').on('click', function(e) {
	  e.preventDefault();
	  loadNotifications();
	});
	
	// Check for new Notifications
	function loadNotifications() {
	   $.ajax({
	      url: 'account/notifications/getNotifications',
	      dataType: 'json',
	      beforeSend: function() {
	          $('#notifications-list').html('<div class="d-flex justify-content-center" id="preloading"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
	          $('#nav-user-main #notifications-list').html('');
	      },
	      complete: function () {
	          $('#preloading').remove();
	      },
	      success: function(json) {
	      	var html = '';

	      	if (json.length > 0) {
	          for (var i = 0; json.length > i; i++) {
	           html = '<li class="list-group-item">';
	           html += '<span class="notification-icon"><i class="icon-material-outline-group"></i></span>';
	           html +=' <span class="notification-text"> ' + json[i].comment + '</span>';
	           html +=' </li>';

	          $('#nav-user-main #notifications-list').append(html);
	        }
	    } else {
	    	$('#nav-user-main #notifications-list').html('<p class="text-center p-3">No New Notifications!</p>');
	      }
	    }
	    });
	  }
	  // Mark Read Notification button
	$(document).on('click', '#button-mark-read', function() {
	  $.ajax({
		url: 'account/notifications/markRead',
	    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'post',
		dataType: 'json',
		beforeSend: function() {
	        $('#nav-user-main #notifications-list').html('<div class="d-flex justify-content-center" id="preloading"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
	        $('#nav-user-main #notifications-count').html('');
	    },
	    complete: function () {
	        $('#preloading').remove();
	    },
		success: function(json) {
			loadNotifications();
	     }
		});
	});
	// check for new Messages
	function loadMessages() {
	   $.ajax({
	      url: 'common/header/getMessages',
	      dataType: 'json',
	      beforeSend: function() {
	          $('#nav-user-main #message-list').html('<div class="d-flex justify-content-center" id="preloading"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
	          $('#nav-user-main #message-list').html('');
	          $('#nav-user-main #message-count').html('');
	      },
	      complete: function () {
	          $('#preloading').remove();
	      },
	      success: function(json) {
	      	var html = '';

	      	if (json.length > 0) {
	          for (var i = 0; json.length > i; i++) {

	           html = '<li class="list-group-item" id="'+json[i].message_id+'">';
	           html += '<a href="account/message#v-pills-'+json[i].thread_id+'">';
	           html += '<span class="notification-avatar status-online float-left"><img src="'+json[i].image+'" alt=""></span>';
	           html += '<div class="notification-text">';
	           html += '<strong>' + json[i].name + '</strong>';
	           html += '<p class="notification-msg-text">' + json[i].message + '<span class="color">' + json[i].date_added + '</span></p>';
	           html += '</div>';
	           html += '</a>';
	           html += '</li>';

	          $('#nav-user-main #message-list').append(html);
	        }
	    } else {
	    	$('#nav-user-main #message-list').html('<li class="text-center list-group-item">No New Messages!</li>');
	      }
	    }
	    });
	  }

	/*--------------------------------------------------*/
	/*  Interactive Effects
	/*--------------------------------------------------*/
	$(".switch, .radio").each(function() {
		var intElem = $(this);
		intElem.on('click', function() {
			intElem.addClass('interactive-effect');
		   setTimeout(function() {
					intElem.removeClass('interactive-effect');
		   }, 400);
		});
	});


	/*--------------------------------------------------*/
	/*  Sliding Button Icon
	/*--------------------------------------------------*/
	$(window).on('load', function() {
		$(".button.button-sliding-icon").not(".task-listing .button.button-sliding-icon").each(function() {
			var buttonWidth = $(this).outerWidth()+30;
			$(this).css('width',buttonWidth);
		});
	});

	/*----------------------------------------------------*/
	/* Dashboard Scripts
	/*----------------------------------------------------*/

	// Mobile Adjustment for Single Button Icon in Dashboard Box
	$('.buttons-to-right').each(function() {
		var btr = $(this).width();
		if (btr < 36) {
			$(this).addClass('single-right-button');
		}
	});

	// Small Footer Adjustment
	$(window).on('load resize', function() {
		var smallFooterHeight = $('.small-footer').outerHeight();
		$('.dashboard-footer-spacer').css({
			'padding-top': smallFooterHeight + 45
		});
	});


	// Auto Resizing Message Input Field
    /* global jQuery */
	jQuery.each(jQuery('textarea[data-autoresize]'), function() {
		var offset = this.offsetHeight - this.clientHeight;

		var resizeTextarea = function(el) {
		    jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
		};
		jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
	});



	/*--------------------------------------------------*/
	/*  Enabling Scrollbar in User Menu
	/*--------------------------------------------------*/
	function userMenuScrollbar() {
		$(".header-notifications-scroll").each(function() {
			var scrollContainerList = $(this).find('ul');
			var itemsCount = scrollContainerList.children("li").length;
      var notificationItems;
      
			// Determines how many items are displayed based on items height
      /* jshint shadow:true */
			if (scrollContainerList.children("li").outerHeight() > 140) {
				var notificationItems = 2;
			} else {
				var notificationItems = 3;
			}
    
      
			// Enables scrollbar if more than 2 items
			if (itemsCount > notificationItems) {

			    var listHeight = 0;

			    $(scrollContainerList).find('li:lt('+notificationItems+')').each(function() {
			       listHeight += $(this).height();
			    });

				$(this).css({ height: listHeight });
		
			} else {
				$(this).css({ height: 'auto' });
				$(this).find('.simplebar-track').hide();
			}
		});
	}

	// Init
	userMenuScrollbar();


	/*--------------------------------------------------*/
	/*  tooltip JS 
	/*--------------------------------------------------*/
    $('[data-toggle=\'tooltip\']').tooltip();

	/*----------------------------------------------------*/
	/*  Payment Accordion
	/*----------------------------------------------------*/
    var radios = document.querySelectorAll('.payment-tab-trigger > input');
 
    for (var i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', expandAccordion);
    }
 
    function expandAccordion (event) {
      /* jshint validthis: true */
      var tabber = this.closest('.payment');
      var allTabs = tabber.querySelectorAll('.payment-tab');
      for (var i = 0; i < allTabs.length; i++) {
        allTabs[i].classList.remove('payment-tab-active');
      }
      event.target.parentNode.parentNode.classList.add('payment-tab-active');
    }

	$('.billing-cycle-radios').on("click", function() {
		if($('.billed-yearly-radio input').is(':checked')) { $('.pricing-plans-container').addClass('billed-yearly'); }
		if($('.billed-monthly-radio input').is(':checked')) { $('.pricing-plans-container').removeClass('billed-yearly'); }
	});

	/*----------------------------------------------------*/
	/*  Inline CSS replacement for backgrounds
	/*----------------------------------------------------*/
	function inlineBG() {

		// Common Inline CSS
		$(".single-page-header, .intro-banner").each(function() {
			var attrImageBG = $(this).attr('data-background-image');

	        if(attrImageBG !== undefined) {
	        	$(this).append('<div class="background-image-container"></div>');
	            $('.background-image-container').css('background-image', 'url('+attrImageBG+')');
	        }
		});

	} inlineBG();

	// Fix for intro banner with label
	$(".intro-search-field").each(function() {
		var bannerLabel = $(this).children("label").length;
		if ( bannerLabel > 0 ){
		    $(this).addClass("with-label");
		}
	});

	// Photo Boxes
	$(".photo-box, .photo-section, .video-container").each(function() {
		var photoBox = $(this);
		var photoBoxBG = $(this).attr('data-background-image');

        if(photoBox !== undefined) {
            $(this).css('background-image', 'url('+photoBoxBG+')');
        }
	});


  	/*----------------------------------------------------*/
    /*  Indicator Bar
    /*----------------------------------------------------*/
	$('.indicator-bar').each(function() {
		var indicatorLenght = $(this).attr('data-indicator-percentage');
		$(this).find("span").css({
			width: indicatorLenght + "%"
		});
	});

  	/*----------------------------------------------------*/
    /*  Slick Carousel
    /*----------------------------------------------------*/
	$('.default-slick-carousel').slick({
		infinite: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		adaptiveHeight: true,
		responsive: [
		    {
		      breakpoint: 1292,
		      settings: {
		        dots: true,
		    	arrows: true
		      }
		    },
		    {
		      breakpoint: 993,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2,
		        dots: true,
		    	arrows: true
		      }
		    },
		    {
		      breakpoint: 769,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        dots: true,
		   		arrows: true
		      }
		    }
	  ]
	});


	$('.testimonial-carousel').slick({
	  centerMode: true,
	  centerPadding: '30%',
	  slidesToShow: 1,
	  dots: false,
	  arrows: true,
	  adaptiveHeight: true,
	  responsive: [
		{
		  breakpoint: 1600,
		  settings: {
			  centerPadding: '21%',
			  slidesToShow: 1,
		  }
		},
		{
		  breakpoint: 993,
		  settings: {
		    centerPadding: '15%',
		    slidesToShow: 1,
		  }
		},
		{
		  breakpoint: 769,
		  settings: {
		    centerPadding: '5%',
		    dots: true,
		    arrows: false
		  }
		}
	  ]
	});


	$('.logo-carousel').slick({
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		responsive: [
			{
			  breakpoint: 1365,
			  settings: {
				slidesToShow: 5,
				dots: true,
				arrows: false
			  }
			},
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 3,
				dots: true,
				arrows: false
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 1,
				dots: true,
				arrows: false
			  }
			}
		]
	});

	$('.blog-carousel').slick({
		infinite: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		responsive: [
			{
			  breakpoint: 1365,
			  settings: {
				slidesToShow: 3,
				dots: true,
				arrows: false
			  }
			},
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 2,
				dots: true,
				arrows: false
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 1,
				dots: true,
				arrows: false
			  }
			}
		]
	});

	$('.navbar-slick-carousel').slick({
		infinite: false,
		slidesToShow: 7,
		slidesToScroll: 2,
		dots: false,
		arrows: true,
		
	});
  	/*----------------------------------------------------*/
    /*  Cats sub-nav hack
    /*----------------------------------------------------*/
	$(document).on('show.bs.dropdown', '#cats-navbar-dropdown', function(e) {
		window.target = e.target;
        var dropdown = $(e.target).find('.dropdown-menu');
         dropdown.appendTo('body');
        $(this).on('hidden.bs.dropdown', function () {
            dropdown.appendTo(e.target);
        })
    });

    const $dropdown = $("#cats-navbar-dropdown");
	const $dropdownToggle = $("#cats-navbar-dropdown .dropdown-toggle");
	const $dropdownMenu = $("#cats-navbar-dropdown .dropdown-menu");
	const showClass = "show";

	$(window).on("load resize", function() {
	  if (this.matchMedia("(min-width: 768px)").matches) {
	    $dropdown.hover(
	      function() {
	        const $this = $(this);
	        $this.addClass(showClass);
	        $this.find($dropdownToggle).attr("aria-expanded", "true");
	        $dropdownMenu.addClass(showClass);
	        $dropdownMenu.appendTo('body');
	      },
	      function() {
	        const $this = $(this);
	        $this.removeClass(showClass);
	        $this.find($dropdownToggle).attr("aria-expanded", "false");
	        $dropdownMenu.on('mouseleave', function() {
				$dropdownMenu.removeClass(showClass);
				$dropdownMenu.appendTo($dropdown[0].outerHTML);
			});
	      }

	    );

	  } else {
	    $dropdown.off("mouseenter mouseleave");
	  }
	});

	// append fragment to url
	var url = document.URL;
	var hash = url.substring(url.indexOf('#'));

	$(".nav-tabs").find("li a").each(function(key, val) {
	    if (hash == $(val).attr('href')) {
	        $(val).click();
	    }
	    
	    $(val).click(function(ky, vl) {
	        location.hash = $(this).attr('href');
	    });
	});

	// Main tabs
	$(".nav-pills").find("li a").each(function(key, val) {
	    if (hash == $(val).attr('href')) {
	        $(val).click();
	    }
	    
	    $(val).click(function(ky, vl) {
	        location.hash = $(this).attr('href');
	    });
	});
});
})(this.jQuery);

