/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){
	
// Search 
$('#search-container button').on('click', function() {

    var url = 'common/search';
    
    var search = $('#search-container #search-input').val();
    if (search) {
        url += '?keyword=' + encodeURIComponent(search);
    }
    ``
    location = url;
});

$('#search-container #search-input').on('keydown', function(e) {

	if (e.keyCode == 13) {
	    $('#search-container button').trigger('click');
	}
});

// Currency
	$('#form-currency #currency-list').on('change', function(e) {
		e.preventDefault();
		$('#form-currency input[name=\'code\']').val($(this).val());

		$('#form-currency').submit();
	});

// Highlight any found errors
$('.text-danger').each(function() {
	var element = $(this).parent();

    console.log(element);
    if (element.hasClass('input-group')) {
        element.addClass('is-invalid');
    }
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


	/*--------------------------------------------------*/
	/*  Sliding Button Icon
	/*--------------------------------------------------*/
    $('.bookmark-icon').on('click', function(e){
    	e.preventDefault();
		$(this).toggleClass('bookmarked');
	});

    $('.bookmark-button').on('click', function(e){
    	e.preventDefault();
		$(this).toggleClass('bookmarked');
	});


	/*----------------------------------------------------*/
	/*  Notifications Boxes
	/*----------------------------------------------------*/
	$("a.close").removeAttr("href").on('click', function(){
		function slideFade(elem) {
			var fadeOut = { opacity: 0, transition: 'opacity 0.5s' };
			elem.css(fadeOut).slideUp();
		}
		slideFade($(this).parent());
	});

	/*--------------------------------------------------*/
	/*  Notification Dropdowns
	/*--------------------------------------------------*/
	$(".header-notifications").each(function() {
		var userMenu = $(this);
		var userMenuTrigger = $(this).find('.header-notifications-trigger a');

		$(userMenuTrigger).on('click', function(event) {
			event.preventDefault();

			if ( $(this).closest(".header-notifications").is(".active") ) {
	            close_user_dropdown();
	        } else {
	            close_user_dropdown();
	            userMenu.addClass('active');
	        }
		});
	});

	// Closing function
    function close_user_dropdown() {
		$('.header-notifications').removeClass("active");
    }

    // Closes notification dropdown on click outside the conatainer
	var mouse_is_inside = false;

	$( ".header-notifications" ).on( "mouseenter", function() {
	  mouse_is_inside=true;
	});
	$( ".header-notifications" ).on( "mouseleave", function() {
	  mouse_is_inside=false;
	});

	$("body").mouseup(function(){
	    if(! mouse_is_inside) close_user_dropdown();
	});

	// Close with ESC
	$(document).keyup(function(e) { 
		if (e.keyCode == 27) {
			close_user_dropdown();
		}
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

	/*--------------------------------------------------*/
	/*  Bootstrap Range Slider
	/*--------------------------------------------------*/

	// Thousand Separator
	function ThousandSeparator(nStr) {
	    nStr += '';
	    var x = nStr.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}

	// Bidding Slider Average Value
	var avgValue = (parseInt($('.bidding-slider').attr("data-slider-min")) + parseInt($('.bidding-slider').attr("data-slider-max")))/2;
	if ($('.bidding-slider').data("slider-value") === 'auto') {
		$('.bidding-slider').attr({'data-slider-value': avgValue});
	}

	// Bidding Slider Init
	$('.bidding-slider').slider();

	$(".bidding-slider").on("slide", function(slideEvt) {
		$("#biddingVal").text(ThousandSeparator(parseInt(slideEvt.value)));
	});
	$("#biddingVal").text(ThousandSeparator(parseInt($('.bidding-slider').val())));


	// Default Bootstrap Range Slider
	var currencyAttr = $(".range-slider").attr('data-slider-currency');
	
	$(".range-slider").slider({
		formatter: function(value) {
			return currencyAttr + ThousandSeparator(parseInt(value[0])) + " - " + currencyAttr + ThousandSeparator(parseInt(value[1]));
		}
	});
	
	$(".range-slider-single").slider();


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


	/*--------------------------------------------------*/
	/*  Quantity Buttons
	/*--------------------------------------------------*/
	// function qtySum(){
	//     var arr = document.getElementsByName('qtyInput');
	//     var tot=0;
	//     for(var i=0;i<arr.length;i++){
	//         if(parseInt(arr[i].value))
	//             tot += parseInt(arr[i].value);
	//     }
	// } 
	// qtySum();

 //   $(".qtyDec, .qtyInc").on("click", function() {

 //      var $button = $(this);
 //      var oldValue = $button.parent().find("input").val();

 //      if ($button.hasClass('qtyInc')) {
 //          $button.parent().find("input").val(parseFloat(oldValue) + 1);
 //      } else {
 //         if (oldValue > 1) {
 //            $button.parent().find("input").val(parseFloat(oldValue) - 1);
 //         } else {
 //            $button.parent().find("input").val(1);
 //         }
 //      }

 //      qtySum();
 //      $(".qtyTotal").addClass("rotate-x");

 //   });




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
	/*  Tabs
	/*----------------------------------------------------*/
	var $tabsNav    = $('.popup-tabs-nav'),
	$tabsNavLis = $tabsNav.children('li');

	$tabsNav.each(function() {
		 var $this = $(this);

		 $this.next().children('.popup-tab-content').stop(true,true).hide().first().show();
		 $this.children('li').first().addClass('active').stop(true,true).show();
	});

	$tabsNavLis.on('click', function(e) {
		 var $this = $(this);

		 $this.siblings().removeClass('active').end().addClass('active');

		 $this.parent().next().children('.popup-tab-content').stop(true,true).hide()
		 .siblings( $this.find('a').attr('href') ).fadeIn();

		 e.preventDefault();
	});

	var hash = window.location.hash;
	var anchor = $('.tabs-nav a[href="' + hash + '"]');
	if (anchor.length === 0) {
		 $(".popup-tabs-nav li:first").addClass("active").show(); //Activate first tab
		 $(".popup-tab-content:first").show(); //Show first tab content
	} else {
		 anchor.parent('li').click();
	}

	// Link to Register Tab
	$('.register-tab').on('click', function(event) {
		event.preventDefault();
		$(".popup-tab-content").hide();
		$("#register.popup-tab-content").show();
		$("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click();
	});

	// Disable tabs if there's only one tab
	$('.popup-tabs-nav').each(function() {
		var listCount = $(this).find("li").length;
		if ( listCount < 2 ) {
			$(this).css({
				'pointer-events': 'none'
			});
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
    /*  Custom Upload Button
    /*----------------------------------------------------*/

	var uploadButton = {
		$button    : $('.uploadButton-input'),
		$nameField : $('.uploadButton-file-name')
	};

	uploadButton.$button.on('change',function() {
		_populateFileField($(this));
	});

	function _populateFileField($button) {
		var selectedFile = [];
	    for (var i = 0; i < $button.get(0).files.length; ++i) {
	        selectedFile.push($button.get(0).files[i].name +'<br>');
	    }
	    uploadButton.$nameField.html(selectedFile);
	}


  	/*----------------------------------------------------*/
    /*  Slick Carousel
    /*----------------------------------------------------*/
	$('.default-slick-carousel').slick({
		infinite: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		adaptiveHeight: true,
		responsive: [
		    {
		      breakpoint: 1292,
		      settings: {
		        dots: true,
		    	arrows: false
		      }
		    },
		    {
		      breakpoint: 993,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2,
		        dots: true,
		    	arrows: false
		      }
		    },
		    {
		      breakpoint: 769,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        dots: true,
		   		arrows: false
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

  	/*----------------------------------------------------*/
    /*  Magnific Popup
    /*----------------------------------------------------*/
	$('.mfp-gallery-container').each(function() { // the containers for all your galleries

		$(this).magnificPopup({
			 type: 'image',
			 delegate: 'a.mfp-gallery',

			 fixedContentPos: true,
			 fixedBgPos: true,

			 overflowY: 'auto',

			 closeBtnInside: false,
			 preloader: true,

			 removalDelay: 0,
			 mainClass: 'mfp-fade',

			 gallery:{enabled:true, tCounter: ''}
		});
	});


	$('.mfp-image').magnificPopup({
		 type: 'image',
		 closeOnContentClick: true,
		 mainClass: 'mfp-fade',
		 image: {
			  verticalFit: true
		 }
	});

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		 disableOn: 700,
		 type: 'iframe',
		 mainClass: 'mfp-fade',
		 removalDelay: 160,
		 preloader: false,

		 fixedContentPos: false
	});



// ------------------ End Document ------------------ //
});

})(this.jQuery);
